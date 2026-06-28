<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialPlanController extends Controller
{
    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $scholarshipAppId = $request->query('app_id');
        
        // Load all scholarship applications for the user (even if not accepted yet)
        $allApplications = \App\Models\ScholarshipApplication::with('scholarship', 'programStudy')
            ->where('user_id', $user->id)
            ->latest('updated_date')
            ->get();
            
        if ($allApplications->isEmpty()) {
            return redirect()->route('scholarship-application.index')->withErrors(['error' => 'You have not added any scholarship yet. Please add a scholarship first.']);
        }
        
        $planQuery = \App\Models\FinancialPlan::with(['items', 'documents'])->where('user_id', $user->id);
        
        if ($scholarshipAppId) {
             $plan = $planQuery->where('scholarship_application_id', $scholarshipAppId)->first();
             if (!$plan) {
                 $plan = \App\Models\FinancialPlan::create([
                     'user_id' => $user->id,
                     'scholarship_application_id' => $scholarshipAppId,
                     'status' => 'draft'
                 ]);
             }
        } else {
             $plan = $planQuery->latest()->first();
             
             if (!$plan) {
                 $latestApp = $allApplications->first();
                 
                 $plan = \App\Models\FinancialPlan::create([
                     'user_id' => $user->id,
                     'scholarship_application_id' => $latestApp->id,
                     'status' => 'draft'
                 ]);
             }
        }

        if ($plan->items->isEmpty()) {
             $this->initializeItems($plan);
             $plan->load('items');
        }

        return view('landing.financial-plan', compact('plan', 'allApplications'));
    }

    private function initializeItems(\App\Models\FinancialPlan $plan)
    {
        $categories = [
            'arrival' => ['Passport', 'Visa', 'Flight Ticket', 'Transportation', 'Settlement Allowance'],
            'education' => ['Registration Fee', 'Tuition Fee', 'Books', 'Research', 'Seminar', 'Journal Publication'],
            'living' => ['Accommodation', 'Food', 'Transportation', 'Insurance', 'Utilities'],
            'family' => ['Family Visa', 'Family Accommodation', 'Family Transportation', 'Family Insurance'],
        ];

        $itemsToInsert = [];
        foreach ($categories as $cat => $items) {
            foreach ($items as $item) {
                $itemsToInsert[] = [
                    'financial_plan_id' => $plan->id,
                    'category' => $cat,
                    'item_name' => $item,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        \App\Models\FinancialPlanItem::insert($itemsToInsert);
    }

    public function save(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:financial_plans,id',
            'items' => 'required|array',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $plan = \App\Models\FinancialPlan::findOrFail($request->plan_id);
            if ($plan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
                abort(403);
            }

            $durStr = $plan->scholarshipApplication->programStudy->study_duration;
            $durMonths = 12;
            if ($durStr) {
                $val = intval($durStr);
                if ($val > 0) {
                    if (str_contains(strtolower($durStr), 'month')) {
                        $durMonths = $val;
                    } else {
                        $durMonths = $val <= 6 ? $val * 12 : $val;
                    }
                }
            }

            $totalCost = 0;
            $totalScholarshipCoverage = 0;
            $totalPersonalCoverage = 0;

            foreach ($request->items as $itemId => $data) {
                $item = \App\Models\FinancialPlanItem::find($itemId);
                if ($item && $item->financial_plan_id == $plan->id) {
                    $estimated = $data['estimated_cost'] ?? 0;
                    $schol = $data['scholarship_coverage'] ?? 0;

                    $item->update([
                        'estimated_cost' => $estimated,
                        'scholarship_coverage' => $schol,
                        'personal_coverage' => 0,
                        'gap_amount' => $schol - $estimated,
                    ]);

                    $totalCost += $estimated;
                    $totalScholarshipCoverage += $schol;
                }
            }

            $totalFunding = $totalScholarshipCoverage;
            $fundingGap = $totalFunding - $totalCost;

            $plan->update([
                'country_destination'  => $plan->scholarshipApplication->programStudy->country,
                'university_name'      => $plan->scholarshipApplication->programStudy->university,
                'study_duration_month' => $durMonths,
                'currency'             => $request->currency ?? 'IDR',
                'scholarship_amount'   => $totalScholarshipCoverage,
                'personal_funding'     => $totalPersonalCoverage,
                'company_support'      => 0,
                'emergency_fund'       => 0,
                'total_estimated_cost' => $totalCost,
                'total_funding'        => $totalFunding,
                'funding_gap'          => $fundingGap
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['success' => true, 'plan' => $plan]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:financial_plans,id',
            'document' => 'required|file|max:5120',
            'document_type' => 'required|string',
        ]);

        $plan = \App\Models\FinancialPlan::findOrFail($request->plan_id);
        if ($plan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('financial_docs', 'public');

            $doc = \App\Models\FinancialDocument::create([
                'financial_plan_id' => $plan->id,
                'document_type' => $request->document_type,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by' => \Illuminate\Support\Facades\Auth::id(),
                'verification_status' => 'pending',
            ]);

            return response()->json(['success' => true, 'document' => $doc]);
        }

        return response()->json(['success' => false], 400);
    }

    public function destroyDocument($id)
    {
        $doc = \App\Models\FinancialDocument::findOrFail($id);
        if ($doc->uploaded_by !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        return response()->json(['success' => true]);
    }

    public function uploadItemFile(Request $request, \App\Models\FinancialPlanItem $item)
    {
        if ($item->financialPlan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $request->validate([
            'document' => 'required|file|max:5120|mimes:pdf,jpeg,png,jpg',
        ]);

        if ($request->hasFile('document')) {
            // Hapus file lama jika ada
            if ($item->reference_file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->reference_file_path);
            }

            $file = $request->file('document');
            $path = $file->store('financial_item_refs', 'public');

            $item->update([
                'reference_file_path' => $path,
                'reference_file_name' => $file->getClientOriginalName(),
            ]);

            return response()->json([
                'success' => true,
                'file_name' => $item->reference_file_name,
                'file_url' => \Illuminate\Support\Facades\Storage::url($path),
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function deleteItemFile(\App\Models\FinancialPlanItem $item)
    {
        if ($item->financialPlan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($item->reference_file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($item->reference_file_path);
        }

        $item->update([
            'reference_file_path' => null,
            'reference_file_name' => null,
        ]);

        return response()->json(['success' => true]);
    }

    public function submit(Request $request)
    {
         $request->validate([
             'plan_id' => 'required|exists:financial_plans,id',
         ]);

         $plan = \App\Models\FinancialPlan::findOrFail($request->plan_id);
         if ($plan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
             abort(403);
         }

         // Load relations for PDF
         $plan->load(['user', 'scholarshipApplication.programStudy', 'items']);

         $plan->update([
             'status' => 'under_review',
             'submitted_at' => now(),
         ]);

         // Generate PDF
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.financial-plan-letter', compact('plan'))
            ->setPaper('a4', 'portrait');
         $pdfContent = $pdf->output();

         $filename = 'Financial-Plan-' . $plan->user->name . '-' . now()->format('Ymd') . '.pdf';

         // Send Email
         \Illuminate\Support\Facades\Mail::to($plan->user->email)
            ->send(new \App\Mail\FinancialPlanMail($plan, $pdfContent, $filename));

         return redirect()->back()->with('success', 'Financial Plan successfully submitted and sent to your email!');
    }
    public function exportExcel(\App\Models\FinancialPlan $plan)
    {
        if ($plan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $filename = 'Financial-Plan-Budget-' . now()->format('Y-m-d') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FinancialPlanItemsExport($plan->id), $filename);
    }

    public function importExcel(Request $request, \App\Models\FinancialPlan $plan)
    {
        if ($plan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if (in_array($plan->status, ['submitted', 'under_review', 'approved'])) {
            return response()->json(['success' => false, 'message' => 'Cannot import when plan is already submitted.'], 400);
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\FinancialPlanItemsImport($plan->id),
                $request->file('excel_file')
            );

            // Final recalculation after all sheets imported
            $items      = \App\Models\FinancialPlanItem::where('financial_plan_id', $plan->id)->get();
            $totalCost  = $items->sum('estimated_cost');
            $totalSchol = $items->sum('scholarship_coverage');
            $plan->update([
                'total_estimated_cost' => $totalCost,
                'total_funding'        => $totalSchol,
                'funding_gap'          => $totalSchol - $totalCost,
                'scholarship_amount'   => $totalSchol,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'All budget items successfully imported from all categories!',
                'summary' => [
                    'total_cost'    => $totalCost,
                    'total_funding' => $totalSchol,
                    'funding_gap'   => $totalSchol - $totalCost,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error importing file: ' . $e->getMessage()], 500);
        }
    }
}
