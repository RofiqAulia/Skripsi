<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MentoringReportController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ScholarshipInsightController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\FinancialPlanController;
use App\Http\Controllers\StudyProgressReportController;

/*
|--------------------------------------------------------------------------
| PUBLIC (BISA DIAKSES SEMUA ORANG)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.home');
})->name('home');

// Scholarship Insights — public (no auth required)
Route::get('/insights', [ScholarshipInsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [ScholarshipInsightController::class, 'show'])->name('insights.show');


/*
|--------------------------------------------------------------------------
| HARUS LOGIN (USER AREA)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'redirect.admin'])->group(function () {

    Route::get('/about', function () {
        return view('landing.about');
    })->name('about');

    Route::get('/psp', [\App\Http\Controllers\PspController::class, 'index'])->name('psp');
    Route::get('/psp/program/{id}', [\App\Http\Controllers\PspController::class, 'showProgram'])->name('psp.program.show');
    Route::post('/psp/apply', [\App\Http\Controllers\PspController::class, 'store'])->name('psp.apply');
    Route::get('/psp/letter/{application}', [\App\Http\Controllers\PspController::class, 'letter'])->name('psp.letter');
    Route::post('/psp/letter/{application}/send', [\App\Http\Controllers\PspController::class, 'sendLetter'])->name('psp.letter.send');


    Route::get('/document', [DocumentController::class, 'index'])->name('document');
    Route::post('/document/upload', [DocumentController::class, 'upload'])->name('document.upload');
    Route::delete('/document/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    
    // Test upload page
    Route::get('/test-upload', function () {
        return view('landing.test-upload');
    })->name('test-upload');

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::post('/dashboard/update-english-score', [\App\Http\Controllers\DashboardController::class, 'updateEnglishScore'])
        ->name('dashboard.update-english-score');

    /*
    |--------------------------------------------------------------------------
    | MENTORING
    |--------------------------------------------------------------------------
    */

    Route::get('/mentoring', [MentorController::class, 'index'])
        ->name('mentoring');
    Route::get('/mentoring/history', [MentorController::class, 'history'])
        ->name('mentoring.history');
    Route::post('/mentoring/select-mentor', [MentorController::class, 'selectMentor'])
        ->name('mentoring.select-mentor');
        
    Route::post('/mentoring/book-schedule', [MentorController::class, 'bookSchedule'])
        ->name('mentoring.book-schedule');
    Route::post('/mentoring/session/{session}/status', [MentorController::class, 'updateStatus'])
        ->name('mentoring.session.update-status');

    /*
    |--------------------------------------------------------------------------
    | REPORT MENTORING
    |--------------------------------------------------------------------------
    */

    Route::get('/report-mentoring', [MentoringReportController::class, 'index'])
        ->name('report-mentoring');

    Route::post('/report-mentoring', [MentoringReportController::class, 'store'])
        ->name('report.store');

    /*
    |--------------------------------------------------------------------------
    | STUDY PROGRESS REPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/study-progress-report', [StudyProgressReportController::class, 'index'])
        ->name('study-progress-report.index');
    Route::get('/study-progress-report/create', [StudyProgressReportController::class, 'create'])
        ->name('study-progress-report.create');
    Route::post('/study-progress-report', [StudyProgressReportController::class, 'store'])
        ->name('study-progress-report.store');
    Route::get('/study-progress-report/{id}/edit', [StudyProgressReportController::class, 'edit'])
        ->name('study-progress-report.edit');
    Route::put('/study-progress-report/{id}', [StudyProgressReportController::class, 'update'])
        ->name('study-progress-report.update');
    Route::get('/study-progress-report/download-template', [StudyProgressReportController::class, 'downloadTemplate'])
        ->name('study-progress-report.download-template');
    Route::post('/study-progress-report/upload', [StudyProgressReportController::class, 'uploadManual'])
        ->name('study-progress-report.upload');

    /*
    |--------------------------------------------------------------------------
    | SCHOLARSHIP APPLICATION
    |--------------------------------------------------------------------------
    */

    Route::prefix('scholarship-application')->name('scholarship-application.')
        ->group(function () {
            Route::get('/',                [ScholarshipApplicationController::class, 'index'])->name('index');
            Route::post('/',               [ScholarshipApplicationController::class, 'store'])->name('store');
            Route::post('/{app}/log',      [ScholarshipApplicationController::class, 'addLog'])->name('addLog');
            Route::post('/log/{log}/update', [ScholarshipApplicationController::class, 'updateLog'])->name('updateLog');
            Route::delete('/{app}',        [ScholarshipApplicationController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('financial-plan')->name('financial-plan.')->group(function () {
        Route::get('/', [FinancialPlanController::class, 'index'])->name('index');
        Route::post('/save', [FinancialPlanController::class, 'save'])->name('save');
        Route::post('/upload', [FinancialPlanController::class, 'upload'])->name('upload');
        Route::delete('/document/{id}', [FinancialPlanController::class, 'destroyDocument'])->name('document.destroy');
        Route::post('/item/{item}/upload', [FinancialPlanController::class, 'uploadItemFile'])->name('item.upload');
        Route::post('/item/{item}/delete-file', [FinancialPlanController::class, 'deleteItemFile'])->name('item.delete-file');
        Route::post('/submit', [FinancialPlanController::class, 'submit'])->name('submit');
        Route::get('/{plan}/export-excel', [FinancialPlanController::class, 'exportExcel'])->name('export-excel');
        Route::post('/{plan}/import-excel', [FinancialPlanController::class, 'importExcel'])->name('import-excel');
    });

    Route::post('/program-study-request', [\App\Http\Controllers\ProgramStudyRequestController::class, 'store'])->name('program-study-request.store');
    Route::put('/program-study-request/{id}', [\App\Http\Controllers\ProgramStudyRequestController::class, 'update'])->name('program-study-request.update');

});

require __DIR__.'/auth.php';

Route::get('/debug-sql', function () {
    $user = \App\Models\User::where('email', 'azir@example.com')->first() ?? \App\Models\User::first();
    auth()->login($user);
    
    $query = \App\Models\PspApplication::query()
        ->where('status', '!=', 'rejected')
        ->where(function ($q) {
            $q->where('status', '!=', 'approved')
              ->orWhere('approval_stage', '<', 3);
        })
        ->where(function (\Illuminate\Database\Eloquent\Builder $query) use ($user) {
            if ($user->hasRole('super_admin')) {
                $query->whereIn('approval_stage', [0, 1, 2]);
                return;
            }

            $isDeptHead = $user->hasRole('pimpinan') && $user->department_id;
            $isGroupHead = $user->hasRole('pimpinan') && !$user->department_id && $user->group_id;
            $isDirHead = $user->hasRole('pimpinan') && !$user->department_id && !$user->group_id && $user->direktorat_id;

            $query->where(function ($q) use ($user, $isDeptHead, $isGroupHead, $isDirHead) {
                if ($isDeptHead) {
                    $q->orWhere(function ($sub) use ($user) {
                        $sub->where('approval_stage', 0)
                          ->whereHas('user', fn($u) => $u->where('department_id', $user->department_id));
                    });
                }
                if ($isGroupHead) {
                    $q->orWhere(function ($sub) use ($user) {
                        $sub->where('approval_stage', 1)
                          ->whereHas('user', fn($u) => $u->where('group_id', $user->group_id));
                    });
                }
                if ($isDirHead) {
                    $q->orWhere(function ($sub) use ($user) {
                        $sub->where('approval_stage', 2)
                          ->whereHas('user', fn($u) => $u->where('direktorat_id', $user->direktorat_id));
                    });
                }
                
                if (!$isDeptHead && !$isGroupHead && !$isDirHead) {
                    $q->whereRaw('1 = 0');
                }
            });
        });

    return [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings(),
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'roles' => $user->roles->pluck('name'),
            'dept' => $user->department_id,
            'group' => $user->group_id,
            'dir' => $user->direktorat_id
        ],
        'results' => $query->get()->toArray()
    ];
});
