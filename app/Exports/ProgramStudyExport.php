<?php

namespace App\Exports;

use App\Models\ProgramStudy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramStudyExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return ProgramStudy::with('submitter')->get();
    }

    public function map($ps): array
    {
        $englishTest = is_array($ps->english_test) ? implode('; ', array_map(function ($item) {
            return is_array($item) ? ($item['value'] ?? json_encode($item)) : (string) $item;
        }, $ps->english_test)) : ($ps->english_test ?? '');

        return [
            $ps->name,
            $ps->scholarship,
            $ps->competency,
            $ps->degree,
            $ps->university,
            $ps->qs_rank,
            $ps->country,
            $ps->website,
            $ps->description,
            $ps->study_type,
            $ps->study_duration,
            $ps->gpa,
            $englishTest,
            $ps->other_language,
            $ps->standardized_test,
            $ps->req_standardized_test ? 'Yes' : 'No',
            $ps->other,
            $ps->open_date?->format('Y-m-d'),
            $ps->deadline?->format('Y-m-d'),
            $ps->screening_date?->format('Y-m-d'),
            $ps->written_test_date?->format('Y-m-d'),
            $ps->interview_date?->format('Y-m-d'),
            $ps->shortlist_date?->format('Y-m-d'),
            $ps->registration_process,
            $ps->requirements,
            $ps->intake,
            $ps->status,
            $ps->submitter->name ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Scholarship',
            'Competency',
            'Degree',
            'University',
            'QS Rank',
            'Country',
            'Website',
            'Description',
            'Study Type',
            'Study Duration',
            'GPA',
            'English Test',
            'Other Language',
            'Standardized Test',
            'Req. Standardized Test',
            'Other',
            'Open Date',
            'Deadline',
            'Screening Date',
            'Written Test Date',
            'Interview Date',
            'Shortlist Date',
            'Registration Process',
            'Requirements',
            'Intake',
            'Status',
            'Submitted By',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
