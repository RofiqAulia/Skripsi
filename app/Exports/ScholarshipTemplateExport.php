<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ScholarshipTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ScholarshipDataSheet(),
            new ScholarshipInstructionSheet(),
        ];
    }
}

// ─── Sheet 1: DATA ───────────────────────────────────────────────────────────

class ScholarshipDataSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function title(): string { return 'Data'; }

    public function headings(): array
    {
        return [
            // Dasar
            'title', 'description', 'funding_type', 'competency', 'country', 'website', 'intake', 'commitment',
            // Program Studi
            'program_study', 'study_count', 'study_duration',
            // Persyaratan
            'age', 'gpa', 'nationality', 'eligibility',
            'english_test', 'other_language', 'standardized_test', 'req_standardized_test',
            'document', 'other', 'benefit',
            // Proses
            'registration_process',
            // Timeline
            'open_date', 'deadline', 'screening_date', 'written_test_date', 'interview_date', 'shortlist_date',
        ];
    }

    public function array(): array
    {
        return [
            [
                'LPDP Scholarship 2026',
                'Beasiswa penuh dari pemerintah Indonesia untuk jenjang S2 dan S3',
                'Full',
                'Advance Digital analytics & Data Science',
                'Indonesia',
                'https://lpdp.kemenkeu.go.id',
                'September 2026',
                'Wajib kembali ke Indonesia setelah lulus dan mengabdi minimal 2x masa studi',
                'Master of Data Science',
                3,
                '2',
                35,
                '3.0',
                'Indonesian',
                'WNI, tidak sedang mendapat beasiswa lain',
                'IELTS:6.5, TOEFL:80',
                '-',
                '-',
                'No',
                'CV, Motivation Letter, Ijazah, Transkrip Nilai',
                'Khusus WNI',
                'Tuition Fee, Living Cost, Book Allowance, Travel',
                'Daftar di portal LPDP → Seleksi Administrasi → Tes Substansi → Interview → Pengumuman',
                '2026-01-01',
                '2026-06-30',
                '2026-07-15',
                '2026-08-01',
                '2026-08-15',
                '2026-09-01',
            ],
            [
                'Chevening Scholarship',
                'UK Government scholarship for future global leaders',
                'Full',
                'Strategic Transformation & Project Management',
                'United Kingdom',
                'https://chevening.org',
                'October 2026',
                '-',
                '',
                1,
                '1',
                '',
                '3.5',
                'All Nationalities',
                'Minimum 2 years work experience',
                'IELTS:6.5',
                '-',
                '-',
                'No',
                'CV, Reference Letter, Essay',
                '-',
                'Tuition Fee, Living Allowance, Travel Cost',
                'Apply online → References → Interview → Shortlist',
                '2026-08-01',
                '2026-11-30',
                '2027-01-15',
                '-',
                '2027-02-01',
                '2027-04-01',
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, 'B' => 40, 'C' => 12, 'D' => 30, 'E' => 18,
            'F' => 30, 'G' => 15, 'H' => 40, 'I' => 25, 'J' => 12,
            'K' => 14, 'L' => 8,  'M' => 8,  'N' => 20, 'O' => 35,
            'P' => 25, 'Q' => 18, 'R' => 20, 'S' => 20, 'T' => 35,
            'U' => 20, 'V' => 35, 'W' => 45, 'X' => 13, 'Y' => 13,
            'Z' => 15, 'AA' => 15, 'AB' => 15, 'AC' => 15,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'AC';
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C62828']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);
        $lastRow = 1 + count($this->array());
        $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3E0']],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ]);
        return [];
    }
}

// ─── Sheet 2: INSTRUCTIONS ───────────────────────────────────────────────────

class ScholarshipInstructionSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    public function title(): string { return 'Petunjuk'; }

    public function array(): array
    {
        return [
            ['📌 PETUNJUK PENGISIAN TEMPLATE SCHOLARSHIP'],
            [''],
            ['KOLOM', 'WAJIB?', 'FORMAT', 'CONTOH'],
            // Dasar
            ['title', 'Ya', 'Teks bebas', 'LPDP Scholarship 2026'],
            ['description', 'Tidak', 'Teks bebas', 'Beasiswa penuh untuk S2 dan S3'],
            ['funding_type', 'Tidak', 'Full / Partial', 'Full'],
            ['competency', 'Tidak', 'Pilih dari daftar kompetensi PSP', 'Advance Digital analytics & Data Science'],
            ['country', 'Tidak', 'Nama negara', 'Indonesia'],
            ['website', 'Tidak', 'URL link beasiswa', 'https://lpdp.kemenkeu.go.id'],
            ['intake', 'Tidak', 'Periode penerimaan', 'September 2026'],
            ['commitment', 'Tidak', 'Kewajiban penerima beasiswa', 'Wajib kembali ke Indonesia...'],
            // Program Studi
            ['program_study', 'Tidak', 'Nama Program Studi yang ADA di database', 'Master of Data Science'],
            ['study_count', 'Tidak', 'Angka (jumlah pilihan program studi)', '3'],
            ['study_duration', 'Tidak', 'Lama studi (tahun)', '2'],
            // Persyaratan
            ['age', 'Tidak', 'Angka batas usia maksimal', '35'],
            ['gpa', 'Tidak', 'Angka IPK minimal', '3.0'],
            ['nationality', 'Tidak', 'Teks bebas', 'Indonesian'],
            ['eligibility', 'Tidak', 'Persyaratan umum kelayakan', 'WNI, tidak sedang mendapat beasiswa lain'],
            ['english_test', 'Tidak', 'NamaTes:Skor dipisah koma', 'IELTS:6.5, TOEFL:80'],
            ['other_language', 'Tidak', 'Teks atau -', '-'],
            ['standardized_test', 'Tidak', 'Nama tes atau -', 'GRE'],
            ['req_standardized_test', 'Tidak', 'Yes / No', 'No'],
            ['document', 'Tidak', 'Nama dokumen dipisah koma', 'CV, Motivation Letter, Ijazah'],
            ['other', 'Tidak', 'Teks bebas atau -', 'Khusus WNI'],
            ['benefit', 'Tidak', 'Nama benefit dipisah koma', 'Tuition Fee, Living Cost'],
            // Proses
            ['registration_process', 'Tidak', 'Teks bebas proses seleksi', 'Daftar di portal → Tes → Interview'],
            // Timeline
            ['open_date', 'Tidak', 'YYYY-MM-DD', '2026-01-01'],
            ['deadline', 'Tidak', 'YYYY-MM-DD', '2026-06-30'],
            ['screening_date', 'Tidak', 'YYYY-MM-DD', '2026-07-15'],
            ['written_test_date', 'Tidak', 'YYYY-MM-DD', '2026-08-01'],
            ['interview_date', 'Tidak', 'YYYY-MM-DD', '2026-08-15'],
            ['shortlist_date', 'Tidak', 'YYYY-MM-DD', '2026-09-01'],
            [''],
            ['CARA IMPORT:'],
            ['1. Isi data di sheet "Data" (hapus baris contoh)'],
            ['2. Simpan file sebagai .xlsx'],
            ['3. Admin Panel → Scholarships → "Import Excel" → Upload → "Import Data"'],
            [''],
            ['CATATAN:'],
            ['• Isi "-" untuk kolom yang tidak ada datanya'],
            ['• Kolom program_study harus sesuai dengan nama Program Study di database'],
            ['• Format english_test: NamaTes:SkorMinimal (misal: IELTS:6.5, TOEFL:80)'],
            ['• Baris kosong akan dilewati otomatis'],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 22, 'B' => 10, 'C' => 45, 'D' => 50];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'C62828']],
        ]);
        $sheet->getStyle('A3:D3')->applyFromArray([
            'font'    => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '424242']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getStyle('A4:D34')->applyFromArray([
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F5F5F5']],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            'alignment' => ['wrapText' => true],
        ]);
        foreach ([35, 39] as $row) {
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(11);
        }
        return [];
    }
}
