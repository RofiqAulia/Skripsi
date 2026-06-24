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
use PhpOffice\PhpSpreadsheet\Style\Color;

class ProgramStudyTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ProgramStudyDataSheet(),
            new ProgramStudyInstructionSheet(),
        ];
    }
}

// ─── Sheet 1: DATA ───────────────────────────────────────────────────────────

class ProgramStudyDataSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function title(): string { return 'Data'; }

    public function headings(): array
    {
        return [
            'name', 'scholarship', 'competency', 'degree', 'university', 'qs_rank', 'country', 'website',
            'description', 'study_type', 'study_duration', 'gpa',
            'english_test', 'other_language', 'standardized_test', 'req_standardized_test', 'other',
            'open_date', 'deadline', 'screening_date', 'written_test_date', 'interview_date', 'shortlist_date',
            'registration_process', 'requirements', 'intake',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Master of Data Science',
                'Oxford Scholarship 2026',
                'Advance Digital analytics & Data Science',
                'Master',
                'University of Oxford',
                1,
                'UK',
                'https://www.ox.ac.uk',
                'Prestigious master program in data science',
                'Full-time',
                '1',
                '3.5',
                'IELTS:7.0; TOEFL:100',
                '-',
                'GRE',
                'Yes',
                'Applicants must have relevant work experience',
                '2026-01-01',
                '2026-06-30',
                '2026-07-15',
                '2026-08-01',
                '2026-08-15',
                '2026-09-01',
                'Apply via university portal. Shortlist based on documents, written test, and interview.',
                'Bachelor degree, Statement of Purpose, Recommendation Letter, CV',
                'September 2026',
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 28, 'B' => 30, 'C' => 30, 'D' => 12, 'E' => 35,
            'F' => 10, 'G' => 15, 'H' => 30, 'I' => 35, 'J' => 12,
            'K' => 10, 'L' => 25, 'M' => 18, 'N' => 20, 'O' => 20,
            'P' => 30, 'Q' => 13, 'R' => 13, 'S' => 16, 'T' => 16,
            'U' => 16, 'V' => 16, 'W' => 40, 'X' => 40, 'Y' => 15, 'Z' => 15,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'Z';
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

class ProgramStudyInstructionSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    public function title(): string { return 'Petunjuk'; }

    public function array(): array
    {
        return [
            ['📌 PETUNJUK PENGISIAN TEMPLATE PROGRAM STUDY'],
            [''],
            ['KOLOM', 'WAJIB?', 'FORMAT', 'CONTOH'],
            ['name', 'Ya', 'Teks bebas', 'Master of Data Science'],
            ['scholarship', 'Tidak', 'Teks bebas (Nama beasiswa)', 'Oxford Scholarship 2026'],
            ['competency', 'Tidak', 'Pilih dari daftar kompetensi PSP', 'Advance Digital analytics & Data Science'],
            ['degree', 'Tidak', 'S1 / S2 / S3 / Master / dll', 'Master'],
            ['university', 'Ya', 'Nama universitas lengkap', 'University of Oxford'],
            ['qs_rank', 'Tidak', 'Angka', '1'],
            ['country', 'Ya', 'Nama negara', 'UK'],
            ['website', 'Tidak', 'URL', 'https://www.ox.ac.uk'],
            ['description', 'Tidak', 'Teks bebas', 'Prestigious master program'],
            ['study_type', 'Tidak', 'Full-time / Part-time / Online / Blended', 'Full-time'],
            ['study_duration', 'Tidak', 'Angka (dalam tahun)', '1'],
            ['gpa', 'Tidak', 'Angka desimal', '3.5'],
            ['english_test', 'Tidak', 'NamaTes:Skor dipisah titik koma (;)', 'IELTS:7.0; TOEFL:100'],
            ['other_language', 'Tidak', 'Teks atau -', '-'],
            ['standardized_test', 'Tidak', 'Nama tes atau -', 'GRE'],
            ['req_standardized_test', 'Tidak', 'Yes / No', 'Yes'],
            ['other', 'Tidak', 'Teks bebas atau -', 'Khusus fresh graduate'],
            ['open_date', 'Tidak', 'YYYY-MM-DD', '2026-01-01'],
            ['deadline', 'Tidak', 'YYYY-MM-DD', '2026-06-30'],
            ['screening_date', 'Tidak', 'YYYY-MM-DD', '2026-07-15'],
            ['written_test_date', 'Tidak', 'YYYY-MM-DD', '2026-08-01'],
            ['interview_date', 'Tidak', 'YYYY-MM-DD', '2026-08-15'],
            ['shortlist_date', 'Tidak', 'YYYY-MM-DD', '2026-09-01'],
            ['registration_process', 'Tidak', 'Teks bebas (cara daftar & seleksi)', 'Apply via portal...'],
            ['requirements', 'Tidak', 'Teks bebas (persyaratan dokumen)', 'Bachelor degree, CV, SOP'],
            ['intake', 'Tidak', 'Teks bebas', 'September 2026'],
            [''],
            ['CARA IMPORT:'],
            ['1. Isi data di sheet "Data" sesuai format (hapus baris contoh)'],
            ['2. Simpan file sebagai .xlsx'],
            ['3. Admin Panel → Program Studies → "Import Excel" → Upload → "Import Data"'],
            [''],
            ['CATATAN:'],
            ['• Baris kosong akan dilewati otomatis'],
            ['• Data yang sudah ada (nama + universitas sama) akan di-update, bukan duplikat'],
            ['• Jangan mengubah nama kolom di baris pertama sheet "Data"'],
            ['• Gunakan "-" untuk kolom yang tidak ada datanya'],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 25, 'B' => 10, 'C' => 45, 'D' => 45];
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
        $sheet->getStyle('A4:D30')->applyFromArray([
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F5F5F5']],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            'alignment' => ['wrapText' => true],
        ]);
        foreach ([31, 35] as $row) {
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(11);
        }
        return [];
    }
}
