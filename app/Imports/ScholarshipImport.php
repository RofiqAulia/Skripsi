<?php

namespace App\Imports;

use App\Models\ProgramStudy;
use App\Models\Scholarship;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class ScholarshipImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected int $rowsImported = 0;
    protected int $rowsSkipped  = 0;
    protected array $errors     = [];

    /**
     * Process the entire collection of rows.
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $row = $row->toArray();

            // Skip completely empty rows
            if (empty(array_filter($row, fn ($v) => $v !== null && $v !== ''))) {
                $this->rowsSkipped++;
                continue;
            }

            // Require at minimum a title
            $title = $this->cleanString($row['title'] ?? null);
            if (empty($title)) {
                $this->rowsSkipped++;
                continue;
            }

            try {
                // Resolve program_study by name
                $programStudyId = null;
                $psValue = $this->cleanString($row['program_study'] ?? null);
                if ($psValue) {
                    $ps = ProgramStudy::where('name', 'LIKE', '%' . $psValue . '%')->first();
                    $programStudyId = $ps?->id;
                }

                // Parse age
                $age = $row['age'] ?? null;
                $age = (!empty($age) && is_numeric($age)) ? (int) $age : null;

                // Parse gpa
                $gpa = $row['gpa'] ?? null;
                $gpa = (!empty($gpa) && $gpa !== '-') ? (string) $gpa : null;

                Scholarship::updateOrCreate(
                    ['title' => $title],
                    [
                        // Dasar
                        'description'           => $this->cleanString($row['description'] ?? null),
                        'funding_type'          => $this->cleanString($row['funding_type'] ?? null),
                        'competency'            => $this->cleanString($row['competency'] ?? null),
                        'country'               => $this->cleanString($row['country'] ?? null),
                        'website'               => $this->cleanString($row['website'] ?? null),
                        'intake'                => $this->cleanString($row['intake'] ?? null),
                        'commitment'            => $this->cleanString($row['commitment'] ?? null),
                        // Program Studi
                        'program_study_id'      => $programStudyId,
                        'study_count'           => $this->cleanInt($row['study_count'] ?? null),
                        'study_duration'        => $this->cleanString($row['study_duration'] ?? null),
                        // Persyaratan
                        'age'                   => $age,
                        'gpa'                   => $gpa,
                        'nationality'           => $this->cleanString($row['nationality'] ?? null),
                        'eligibility'           => $this->cleanString($row['eligibility'] ?? null),
                        'english_test'          => $this->parseEnglishTest($row['english_test'] ?? null),
                        'other_language'        => $this->cleanString($row['other_language'] ?? null),
                        'standardized_test'     => $this->cleanString($row['standardized_test'] ?? null),
                        'req_standardized_test' => $this->parseBool($row['req_standardized_test'] ?? null),
                        'document'              => $this->parseList($row['document'] ?? null, 'document_name'),
                        'other'                 => $this->cleanString($row['other'] ?? null),
                        'benefit'               => $this->parseList($row['benefit'] ?? null, 'benefit_detail'),
                        // Proses Seleksi
                        'registration_process'  => $this->cleanString($row['registration_process'] ?? null),
                        // Timeline
                        'open_date'             => $this->parseDate($row['open_date'] ?? null),
                        'deadline'              => $this->parseDate($row['deadline'] ?? null),
                        'screening_date'        => $this->parseDate($row['screening_date'] ?? null),
                        'written_test_date'     => $this->parseDate($row['written_test_date'] ?? null),
                        'interview_date'        => $this->parseDate($row['interview_date'] ?? null),
                        'shortlist_date'        => $this->parseDate($row['shortlist_date'] ?? null),
                    ]
                );

                $this->rowsImported++;
            } catch (\Exception $e) {
                $this->errors[] = "Baris [{$title}]: " . $e->getMessage();
            }
        }
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    protected function cleanString(mixed $value): ?string
    {
        if ($value === null || $value === '' || $value === '-') return null;
        $str = trim((string) $value);
        return $str !== '' ? $str : null;
    }

    protected function cleanInt(mixed $value): ?int
    {
        if ($value === null || $value === '' || $value === '-') return null;
        return is_numeric($value) ? (int) $value : null;
    }

    protected function parseBool(mixed $value): ?bool
    {
        if ($value === null || $value === '' || $value === '-') return null;
        $v = strtolower(trim((string) $value));
        if (in_array($v, ['yes', 'ya', '1', 'true']))    return true;
        if (in_array($v, ['no', 'tidak', '0', 'false'])) return false;
        return null;
    }

    /**
     * Parse "IELTS:6.5, TOEFL:80" → [["test_name":"IELTS","minimum_score":"6.5"],...]
     */
    protected function parseEnglishTest(mixed $value): ?array
    {
        if (empty($value) || $value === '-') return null;

        $tests  = array_map('trim', explode(',', (string) $value));
        $result = [];
        foreach ($tests as $test) {
            if (empty($test)) continue;
            if (str_contains($test, ':')) {
                [$name, $score] = array_map('trim', explode(':', $test, 2));
                $result[] = ['test_name' => $name, 'minimum_score' => $score];
            } else {
                $result[] = ['test_name' => $test, 'minimum_score' => ''];
            }
        }
        return !empty($result) ? $result : null;
    }

    /**
     * Parse a comma-separated list into an array of objects.
     * e.g. "CV, SOP" → [{"document_name":"CV"},{"document_name":"SOP"}]
     */
    protected function parseList(mixed $value, string $key): ?array
    {
        if (empty($value) || $value === '-') return null;

        $items  = array_map('trim', explode(',', (string) $value));
        $result = [];
        foreach ($items as $item) {
            if (!empty($item)) {
                $result[] = [$key => $item];
            }
        }
        return !empty($result) ? $result : null;
    }

    protected function parseDate(mixed $value): ?string
    {
        if (empty($value) || $value === '-') return null;

        if (is_numeric($value) && (int) $value > 10000) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date
                    ::excelToDateTimeObject((int) $value)
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return Carbon::parse((string) $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    // ─── Stats ───────────────────────────────────────────────────────────────

    public function chunkSize(): int    { return 500; }
    public function getRowsImported(): int { return $this->rowsImported; }
    public function getRowsSkipped(): int  { return $this->rowsSkipped; }
    public function getErrors(): array     { return $this->errors; }
}
