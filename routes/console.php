<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('generate-pdfs', function () {
    $pdfAdmin = \Barryvdh\DomPDF\Facade\Pdf::loadView('docs.panduan-admin');
    $pdfAdmin->save(public_path('docs/Buku_Panduan_Admin_SOVIA.pdf'));
    $this->info('Admin PDF generated.');
    
    $pdfPimpinan = \Barryvdh\DomPDF\Facade\Pdf::loadView('docs.panduan-pimpinan');
    $pdfPimpinan->save(public_path('docs/Buku_Panduan_Pimpinan_SOVIA.pdf'));
    $this->info('Pimpinan PDF generated.');
    
    $pdfMentor = \Barryvdh\DomPDF\Facade\Pdf::loadView('docs.panduan-mentor');
    $pdfMentor->save(public_path('docs/Buku_Panduan_Mentor_SOVIA.pdf'));
    $this->info('Mentor PDF generated.');
});
