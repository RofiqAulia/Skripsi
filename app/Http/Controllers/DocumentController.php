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
            ->keyBy('type');

        // Build the view data for each required type
        $documentTypes = collect(Document::REQUIRED_TYPES)->map(function ($label, $type) use ($userDocuments) {
            $doc = $userDocuments->get($type);

            return (object) [
                'type'        => $type,
                'label'       => $label,
                'document'    => $doc,
                'status'      => $doc ? $doc->status : 'not_uploaded',
                'notes'       => $doc?->notes,
                'reviewed_at' => $doc?->reviewed_at,
                'file'        => $doc?->file,
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
                'file'     => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ], [
                'file.required' => 'Please select a file to upload.',
                'file.file'     => 'The file must be a valid file.',
                'file.mimes'    => 'File type is not allowed. Please use: PDF, DOC, DOCX, JPG, or PNG.',
                'file.max'      => 'File size exceeds the 10 MB limit.',
                'type.required' => 'Document type is required.',
            ]);

            $user = Auth::user();
            $type = $validated['type'];
            $category = $validated['category'] ?? 'required';

            // Verify the file exists in the request
            if (!$request->hasFile('file')) {
                return $this->errorResponse('No file was uploaded.', 422);
            }

            $file = $request->file('file');

            // Double-check file validity
            if (!$file->isValid()) {
                return $this->errorResponse('The uploaded file is not valid.', 422);
            }

            // Store file
            try {
                $path = $file->store('documents/' . $user->id, 'public');

                if (!$path) {
                    return $this->errorResponse('Failed to store the file. Please try again.', 500);
                }
            } catch (\Exception $e) {
                return $this->errorResponse('Failed to store the file: ' . $e->getMessage(), 500);
            }

            // Delete old file if re-uploading
            $existing = Document::where('user_id', $user->id)
                ->where('type', $type)
                ->where('category', $category)
                ->first();

            if ($existing && $existing->file) {
                try {
                    Storage::disk('public')->delete($existing->file);
                } catch (\Exception $e) {
                    // Log but don't fail - the new file is already stored
                    \Log::warning('Failed to delete old document file: ' . $e->getMessage());
                }
            }

            // Create or update
            try {
                $document = Document::updateOrCreate(
                    [
                        'user_id'  => $user->id,
                        'type'     => $type,
                        'category' => $category,
                    ],
                    [
                        'file'        => $path,
                        'status'      => 'uploaded',   // Reset to uploaded on re-upload
                        'notes'       => null,          // Clear previous notes
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                    ]
                );

                // Check if this is an AJAX request
                if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Document uploaded successfully! It is now awaiting review.',
                        'document' => $document,
                    ], 200);
                }

                return redirect()->route('document')->with('success', 'Document uploaded successfully! It is now awaiting review.');
            } catch (\Exception $e) {
                // Clean up the stored file if document creation fails
                if (isset($path)) {
                    try {
                        Storage::disk('public')->delete($path);
                    } catch (\Exception $deleteError) {
                        \Log::error('Failed to clean up uploaded file: ' . $deleteError->getMessage());
                    }
                }

                return $this->errorResponse('Failed to save document record: ' . $e->getMessage(), 500);
            }
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
