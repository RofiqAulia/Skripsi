<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MentoringReportController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ScholarshipInsightController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\FinancialPlanController;

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

Route::middleware(['auth'])->group(function () {

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
    });

});

require __DIR__.'/auth.php';
