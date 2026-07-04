<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Studi Karyawan</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            color: #000; 
            padding: 20px 40px; 
        }
        .title { 
            text-align: center; 
            font-size: 14pt; 
            font-weight: bold; 
            margin-bottom: 30px; 
        }
        .section-title { 
            font-weight: bold; 
            margin-bottom: 10px; 
            margin-top: 20px; 
            text-decoration: underline;
        }
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
        }
        table.data-table td { 
            padding: 3px 0; 
            vertical-align: top; 
        }
        table.data-table td.label { 
            width: 220px; 
        }
        table.data-table td.colon { 
            width: 20px; 
        }
        table.grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        table.grid-table th, table.grid-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        table.grid-table th {
            font-weight: bold;
        }
        .signature-section { 
            margin-top: 50px; 
        }
        .signature-text {
            margin-bottom: 30px;
        }
        .signature-box { 
            float: right;
            text-align: center; 
            min-width: 200px; 
        }
        .signature-name { 
            font-weight: bold; 
            text-decoration: underline; 
            margin-top: 70px; 
        }
        .clear {
            clear: both;
        }
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <div class="title">
        LAPORAN PERKEMBANGAN STUDI KARYAWAN<br>
        PROGRAM TUGAS BELAJAR DI LUAR NEGERI
    </div>

    <div class="section-title">Data Karyawan</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $user->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Posisi / Jabatan Semula</td>
            <td class="colon">:</td>
            <td>{{ $user->position ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Unit Kerja Semula</td>
            <td class="colon">:</td>
            <td>
                @php
                    $departmentName = $user->department ? $user->department->name : '';
                    $groupName = $user->group ? $user->group->name : '';
                    $dirName = $user->direktorat ? $user->direktorat->name : '';
                    $workUnit = implode(' / ', array_filter([$departmentName, $groupName, $dirName]));
                @endphp
                {{ $workUnit ?: '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Perusahaan</td>
            <td class="colon">:</td>
            <td>{{ $user->company ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Data Studi</div>
    <table class="data-table">
        <tr>
            <td class="label">Program Studi</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->studyPlan->programStudy->name ?? '-' }} ({{ strtoupper($pspApplication->studyPlan->programStudy->degree ?? '') }})</td>
        </tr>
        <tr>
            <td class="label">Universitas</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->studyPlan->programStudy->university ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Mulai Studi</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->scholarshipApplication->batch->start_date ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Rencana Lama Studi</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->studyPlan->duration_months ?? '-' }} Bulan</td>
        </tr>
        <tr>
            <td class="label">Semester</td>
            <td class="colon">:</td>
            <td>{{ $report->semester }}</td>
        </tr>
        <tr>
            <td class="label">IPK / Max. IPK</td>
            <td class="colon">:</td>
            <td>{{ $report->gpa }} / {{ $report->max_gpa }}</td>
        </tr>
    </table>

    <div class="section-title">Laporan Studi</div>
    
    <strong>Mata Kuliah yang sudah dijalankan</strong>
    @if(!empty($report->completed_courses) && count($report->completed_courses) > 0)
        <table class="grid-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS / Credits</th>
                    <th>Nilai / Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->completed_courses as $index => $course)
                    <tr>
                        <td width="30">{{ $index + 1 }}</td>
                        <td>{{ $course['course_name'] ?? '-' }}</td>
                        <td width="100">{{ $course['credits'] ?? '-' }}</td>
                        <td width="100">{{ $course['grade'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="margin-top: 5px;">-</p>
    @endif

    <strong>Mata Kuliah yang sedang dijalankan</strong>
    @if(!empty($report->ongoing_courses) && count($report->ongoing_courses) > 0)
        <table class="grid-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS / Credits</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->ongoing_courses as $index => $course)
                    <tr>
                        <td width="30">{{ $index + 1 }}</td>
                        <td>{{ $course['course_name'] ?? '-' }}</td>
                        <td width="150">{{ $course['credits'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="margin-top: 5px;">-</p>
    @endif

    <strong>Mata Kuliah yang belum dan akan dijalankan</strong>
    @if(!empty($report->upcoming_courses) && count($report->upcoming_courses) > 0)
        <table class="grid-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS / Credits</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->upcoming_courses as $index => $course)
                    <tr>
                        <td width="30">{{ $index + 1 }}</td>
                        <td>{{ $course['course_name'] ?? '-' }}</td>
                        <td width="150">{{ $course['credits'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="margin-top: 5px;">-</p>
    @endif

    <div class="section-title no-break">Penjelasan Tesis / Penelitian</div>
    <table class="data-table">
        <tr>
            <td class="label">Judul</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_title ?? '-' }} (Status: {{ ucfirst(str_replace('_', ' ', $report->thesis_title_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Proposal Tesis</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_proposal ?? '-' }} (Status: {{ ucfirst(str_replace('_', ' ', $report->thesis_proposal_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Ujian Proposal</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->proposal_exam_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Tanggal Ujian</td>
            <td class="colon">:</td>
            <td>{{ $report->proposal_exam_date ? \Carbon\Carbon::parse($report->proposal_exam_date)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nilai Ujian</td>
            <td class="colon">:</td>
            <td>{{ $report->proposal_exam_score ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Perbaikan / Revisi Proposal</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->proposal_revision_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Pelaksanaan Penelitian</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->research_implementation_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Pengumpulan Data</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->data_collection_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Analisis Data</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->data_analysis_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Penulisan Tesis</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->thesis_writing_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Ujian Tesis</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->thesis_exam_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Tanggal Ujian</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_exam_date ? \Carbon\Carbon::parse($report->thesis_exam_date)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nilai Ujian</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_exam_score ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Perbaikan / Revisi Tesis</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->thesis_revision_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Penulisan Artikel Jurnal</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->journal_article_status ?? '-')) }})</td>
        </tr>
        <tr>
            <td class="label">Publikasi Jurnal</td>
            <td class="colon">:</td>
            <td>(Status: {{ ucfirst(str_replace('_', ' ', $report->journal_publication_status ?? '-')) }})</td>
        </tr>
    </table>

    <div class="section-title">Kegiatan Akademik Lainnya</div>
    @if(!empty($report->other_academic_activities) && count($report->other_academic_activities) > 0)
        @foreach($report->other_academic_activities as $activity)
            <table class="data-table" style="margin-bottom: 5px;">
                <tr>
                    <td class="label" style="width: 150px;">Jenis Kegiatan</td>
                    <td class="colon">:</td>
                    <td>Seminar / Workshop / Training</td>
                </tr>
                <tr>
                    <td class="label">Nama Kegiatan</td>
                    <td class="colon">:</td>
                    <td>{{ $activity['activity_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal / Tempat</td>
                    <td class="colon">:</td>
                    <td>{{ $activity['activity_date'] ? \Carbon\Carbon::parse($activity['activity_date'])->format('d M Y') : '-' }} / -</td>
                </tr>
                <tr>
                    <td class="label">Sertifikat</td>
                    <td class="colon">:</td>
                    <td>{{ $activity['activity_description'] ?? '-' }}</td>
                </tr>
            </table>
            <br>
        @endforeach
    @else
        <p style="margin-top: 5px;">-</p>
    @endif

    <div class="section-title">Catatan :</div>
    <p style="min-height: 50px;">-</p>

    <div class="signature-section no-break">
        <div class="signature-text">
            Demikian laporan perkembangan studi ini saya buat dengan sebenar benarnya.
        </div>
        
        <div class="signature-box">
            <div style="margin-bottom: 20px;">
                @php
                    $country = $pspApplication->studyPlan->programStudy->country ?? 'Indonesia';
                @endphp
                {{ $country }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
            
            @if($report->signature_image || $report->signature_pad || $user->signature_image || $user->signature_pad)
                <div>
                    @php
                        $sigSrc = '';
                        if ($report->signature_pad) {
                            $sigSrc = $report->signature_pad;
                        } elseif ($report->signature_image) {
                            $path = storage_path('app/public/' . $report->signature_image);
                            if (file_exists($path)) {
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $data = base64_encode(file_get_contents($path));
                                $sigSrc = 'data:image/' . $ext . ';base64,' . $data;
                            }
                        } elseif ($user->signature_pad) {
                            $sigSrc = $user->signature_pad;
                        } elseif ($user->signature_image) {
                            $path = storage_path('app/public/' . $user->signature_image);
                            if (file_exists($path)) {
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $data = base64_encode(file_get_contents($path));
                                $sigSrc = 'data:image/' . $ext . ';base64,' . $data;
                            }
                        }
                    @endphp
                    @if($sigSrc)
                        <img src="{{ $sigSrc }}" style="max-height: 80px;" alt="Signature">
                    @else
                        <div style="height: 80px;"></div>
                    @endif
                </div>
            @else
                <div style="height: 80px;"></div>
            @endif
            
            <div class="signature-name">{{ strtoupper($user->name) }}</div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
