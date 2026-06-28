<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display the document upload page with real status data.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch all documents belonging to this user
        $userDocuments = Document::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('type');

        // Build the view data for each required type
        $documentTypes = collect(Document::REQUIRED_TYPES)->map(function ($label, $type) use ($userDocuments) {
            $docs = $userDocuments->get($type, collect());
            $firstDoc = $docs->first();

            return (object) [
                'type'        => $type,
                'label'       => $label,
                'documents'   => $docs, // Collection of all documents for this type
                'status'      => $firstDoc ? $firstDoc->status : 'not_uploaded',
                'notes'       => $firstDoc?->notes,
                'reviewed_at' => $firstDoc?->reviewed_at,
            ];
        });

        // Also fetch any "other" supporting documents
        $otherDocuments = Document::where('user_id', $user->id)
            ->where('category', 'other')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Stats
        $totalRequired = count(Document::REQUIRED_TYPES) + $otherDocuments->count();
        $approvedCount = $userDocuments->where('status', 'approved')->count();

        return view('landing.upload-doc', compact(
            'documentTypes',
            'totalRequired',
            'approvedCount',
            'otherDocuments',
        ));
    }

    /**
     * Handle document upload for a specific type.
     */
    public function upload(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'type'     => 'required|string|max:50',
                'category' => 'nullable|string|max:50',
                'file'     => 'required',
            ], [
                'file.required' => 'Please select a file to upload.',
                'type.required' => 'Document type is required.',
            ]);

            // Validate the file(s)
            $request->validate([
                'file' => $request->hasFile('file') && is_array($request->file('file')) ? 'array' : 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'file.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ], [
                'file.file'     => 'The file must be a valid file.',
                'file.mimes'    => 'File type is not allowed. Please use: PDF, DOC, DOCX, JPG, or PNG.',
                'file.max'      => 'File size exceeds the 10 MB limit.',
                'file.*.file'   => 'One of the files is not valid.',
                'file.*.mimes'  => 'File type is not allowed. Please use: PDF, DOC, DOCX, JPG, or PNG.',
                'file.*.max'    => 'File size exceeds the 10 MB limit.',
            ]);

            $user = Auth::user();
            $type = $validated['type'];
            $category = $validated['category'] ?? 'required';

            if (!$request->hasFile('file')) {
                return $this->errorResponse('No file was uploaded.', 422);
            }

            $files = is_array($request->file('file')) ? $request->file('file') : [$request->file('file')];
            $uploadedDocuments = [];

            foreach ($files as $file) {
                if (!$file->isValid()) {
                    continue; // Skip invalid files
                }

                // Store file
                try {
                    $path = $file->store('documents/' . $user->id, 'public');
                } catch (\Exception $e) {
                    \Log::error('Failed to store the file: ' . $e->getMessage());
                    continue;
                }

                if ($type !== 'other') {
                    // Delete old file if re-uploading a REQUIRED doc
                    $existing = Document::where('user_id', $user->id)
                        ->where('type', $type)
                        ->where('category', $category)
                        ->first();

                    if ($existing && $existing->file) {
                        try {
                            Storage::disk('public')->delete($existing->file);
                        } catch (\Exception $e) {
                            \Log::warning('Failed to delete old document file: ' . $e->getMessage());
                        }
                    }

                    // Update or Create
                    $document = Document::updateOrCreate(
                        [
                            'user_id'  => $user->id,
                            'type'     => $type,
                            'category' => $category,
                        ],
                        [
                            'file'        => $path,
                            'status'      => 'uploaded',
                            'notes'       => null,
                            'reviewed_by' => null,
                            'reviewed_at' => null,
                        ]
                    );
                } else {
                    // For 'other' documents, ALWAYS CREATE a new record to support multiple files
                    $document = Document::create([
                        'user_id'  => $user->id,
                        'type'     => $type, // 'other'
                        'category' => $category, // 'other'
                        'file'     => $path,
                        'status'      => 'uploaded',
                        'notes'       => null,
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                    ]);
                }

                $uploadedDocuments[] = $document;
            }

            if (empty($uploadedDocuments)) {
                return $this->errorResponse('Failed to save document records.', 500);
            }

            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => count($uploadedDocuments) > 1 
                                 ? count($uploadedDocuments) . ' documents uploaded successfully!'
                                 : 'Document uploaded successfully! It is now awaiting review.',
                    'documents' => $uploadedDocuments,
                ], 200);
            }

            return redirect()->route('document')->with('success', 'Document(s) uploaded successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Document upload error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e,
            ]);

            return $this->errorResponse('An unexpected error occurred. Please try again later.', 500);
        }
    }

    /**
     * Return error response (handles both JSON and redirect)
     */
    private function errorResponse($message, $statusCode = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => ['file' => [$message]],
        ], $statusCode);
    }

    /**
     * Delete a document (only if not yet approved).
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $document = Document::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Prevent deleting approved documents
        if ($document->status === 'approved') {
            return redirect()->route('document')->with('error', 'Cannot delete an approved document.');
        }

        // Delete file from storage
        if ($document->file) {
            Storage::disk('public')->delete($document->file);
        }

        $document->delete();

        return redirect()->route('document')->with('success', 'Document deleted successfully.');
    }
}
