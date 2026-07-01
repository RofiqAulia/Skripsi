<?php

namespace App\Imports;

use App\Models\ProgramStudy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class ProgramStudyImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected int $rowsImported  = 0;
    protected int $rowsSkipped   = 0;
    protected array $errors      = [];

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

            // Only 'name' is required; all other columns may be empty
            $name = $this->cleanString($row['name'] ?? null);

            if (empty($name)) {
                $this->rowsSkipped++;
                continue;
            }

            $university = $this->cleanString($row['university'] ?? null);

            try {
                $competencyName = $this->cleanString($row['competency'] ?? null);
                $countryName = $this->cleanString($row['country'] ?? null);
                
                if ($competencyName) {
                    \App\Models\Competency::firstOrCreate(['name' => $competencyName]);
                }
                
                if ($countryName) {
                    \App\Models\Country::firstOrCreate(['name' => $countryName]);
                }

                // Unique key: name + university (university may be null)
                ProgramStudy::updateOrCreate(
                    ['name' => $name, 'university' => $university],
                    [
                        'scholarship'           => $this->cleanString($row['scholarship'] ?? null),
                        'competency'            => $competencyName,
                        'degree'                => $this->cleanString($row['degree'] ?? null),
                        'country'               => $countryName,
                        'qs_rank'               => $this->cleanInt($row['qs_rank'] ?? null),
                        'website'               => $this->cleanString($row['website'] ?? null),
                        'description'           => $this->cleanString($row['description'] ?? null),
                        'study_type'            => $this->cleanString($row['study_type'] ?? null),
                        'study_duration'        => $this->cleanString($row['study_duration'] ?? null),
                        'gpa'                   => $this->cleanString($row['gpa'] ?? null),
                        'english_test'          => $this->parseEnglishTest($row['english_test'] ?? null),
                        'other_language'        => $this->cleanString($row['other_language'] ?? null),
                        'standardized_test'     => $this->cleanString($row['standardized_test'] ?? null),
                        'req_standardized_test' => $this->parseBool($row['req_standardized_test'] ?? null),
                        'other'                 => $this->cleanString($row['other'] ?? null),
                        'open_date'             => $this->parseDate($row['open_date'] ?? null),
                        'deadline'              => $this->parseDate($row['deadline'] ?? null),
                        'screening_date'        => $this->parseDate($row['screening_date'] ?? null),
                        'written_test_date'     => $this->parseDate($row['written_test_date'] ?? null),
                        'interview_date'        => $this->parseDate($row['interview_date'] ?? null),
                        'shortlist_date'        => $this->parseDate($row['shortlist_date'] ?? null),
                        'registration_process'  => $this->cleanString($row['registration_process'] ?? null),
                        'requirements'          => $this->cleanString($row['requirements'] ?? null),
                        'intake'                => $this->cleanString($row['intake'] ?? null),
                    ]
                );

                $this->rowsImported++;
            } catch (\Exception $e) {
                $this->errors[] = "Baris [{$name}]: " . $e->getMessage();
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
        if (in_array($v, ['yes', 'ya', '1', 'true']))  return true;
        if (in_array($v, ['no', 'tidak', '0', 'false'])) return false;
        return null;
    }

    /**
     * Parse "IELTS:6.5; TOEFL:80" → [["test_name":"IELTS","minimum_score":"6.5"],...]
     */
    protected function parseEnglishTest(mixed $value): ?array
    {
        if (empty($value) || $value === '-') return null;

        $tests  = array_map('trim', explode(';', (string) $value));
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

    protected function parseDate(mixed $value): ?string
    {
        if (empty($value) || $value === '-') return null;

        // Handle Excel serial date numbers
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
