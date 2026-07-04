<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Study Progress Report - {{ $user->name }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 13px; 
            line-height: 1.5; 
            color: #000; 
            padding: 30px; 
        }
        .logo { 
            width: 150px; 
            margin-bottom: 30px; 
        }
        .title { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 20px; 
            text-transform: uppercase; 
        }
        .subtitle {
            text-align: center; 
            font-size: 13px; 
            margin-bottom: 40px; 
        }
        .section-title { 
            font-weight: bold; 
            margin-bottom: 12px; 
            margin-top: 25px; 
            font-size: 13px; 
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            margin-left: 10px; 
        }
        table.data-table td { 
            padding: 5px 0; 
            vertical-align: top; 
        }
        table.data-table td.label { 
            width: 180px; 
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
            padding: 8px;
            text-align: left;
        }
        table.grid-table th {
            background-color: #f2f2f2;
        }
        .signature-section { 
            margin-top: 80px; 
            text-align: right; 
        }
        .signature-box { 
            display: inline-block; 
            text-align: center; 
            min-width: 250px; 
        }
        .signature-name { 
            font-weight: bold; 
            text-decoration: underline; 
            margin-top: 80px; 
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('images/rpx-logo.png');
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSrc = 'data:image/png;base64,' . $logoData;
        } else {
            $logoSrc = '';
        }
    @endphp

    @if($logoSrc)
        <img src="{{ $logoSrc }}" class="logo" alt="RPX Logo">
    @endif

    <div class="title">STUDY PROGRESS REPORT</div>
    <div class="subtitle">SEMESTER {{ $report->semester }}</div>

    <div class="section-title">A. INFORMASI KARYAWAN & STUDI</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $user->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Perusahaan</td>
            <td class="colon">:</td>
            <td>{{ $user->company ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $user->position ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Departemen</td>
            <td class="colon">:</td>
            <td>{{ $user->department->name ?? '-' }}</td>
        </tr>
        
        @if($pspApplication && $pspApplication->studyPlan && $pspApplication->studyPlan->programStudy)
        <tr>
            <td class="label">Universitas & Negara</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->studyPlan->programStudy->university ?? '-' }} · {{ $pspApplication->studyPlan->programStudy->country ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td class="colon">:</td>
            <td>{{ $pspApplication->studyPlan->programStudy->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Gelar</td>
            <td class="colon">:</td>
            <td>{{ strtoupper($pspApplication->studyPlan->programStudy->degree ?? '-') }}</td>
        </tr>
        @endif
        
        <tr>
            <td class="label">IPK Saat Ini</td>
            <td class="colon">:</td>
            <td>{{ $report->gpa }} / {{ $report->max_gpa }}</td>
        </tr>
    </table>


    <div class="section-title">B. PERKEMBANGAN MATA KULIAH</div>
    
    <strong>1. Mata Kuliah yang Telah Ditempuh (Completed)</strong>
    @if(!empty($report->completed_courses) && is_array($report->completed_courses))
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
        <p style="margin-left:10px;"><em>Tidak ada data.</em></p>
    @endif

    <strong>2. Mata Kuliah yang Sedang Ditempuh (Ongoing)</strong>
    @if(!empty($report->ongoing_courses) && is_array($report->ongoing_courses))
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
        <p style="margin-left:10px;"><em>Tidak ada data.</em></p>
    @endif

    <strong>3. Mata Kuliah yang Akan Ditempuh (Upcoming)</strong>
    @if(!empty($report->upcoming_courses) && is_array($report->upcoming_courses))
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
        <p style="margin-left:10px;"><em>Tidak ada data.</em></p>
    @endif


    <div class="section-title">C. DATA TESIS & PENELITIAN</div>
    <table class="data-table">
        <tr>
            <td class="label">Judul Tesis</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_title ?? '-' }} ({{ ucfirst(str_replace('_', ' ', $report->thesis_title_status ?? '')) }})</td>
        </tr>
        <tr>
            <td class="label">Proposal Tesis</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_proposal ?? '-' }} ({{ ucfirst(str_replace('_', ' ', $report->thesis_proposal_status ?? '')) }})</td>
        </tr>
        <tr>
            <td class="label">Status Sidang Proposal</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->proposal_exam_status ?? '-')) }}</td>
        </tr>
        @if($report->proposal_exam_date)
        <tr>
            <td class="label">Tanggal Sidang Proposal</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($report->proposal_exam_date)->format('d F Y') }}</td>
        </tr>
        @endif
        @if($report->proposal_exam_score)
        <tr>
            <td class="label">Nilai Sidang Proposal</td>
            <td class="colon">:</td>
            <td>{{ $report->proposal_exam_score }}</td>
        </tr>
        @endif
        
        <tr><td colspan="3">&nbsp;</td></tr>
        
        <tr>
            <td class="label">Implementasi Riset</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->research_implementation_status ?? '-')) }}</td>
        </tr>
        <tr>
            <td class="label">Pengumpulan Data</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->data_collection_status ?? '-')) }}</td>
        </tr>
        <tr>
            <td class="label">Analisis Data</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->data_analysis_status ?? '-')) }}</td>
        </tr>
        <tr>
            <td class="label">Penulisan Tesis</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->thesis_writing_status ?? '-')) }}</td>
        </tr>

        <tr><td colspan="3">&nbsp;</td></tr>

        <tr>
            <td class="label">Sidang Akhir Tesis</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->thesis_exam_status ?? '-')) }}</td>
        </tr>
        @if($report->thesis_exam_date)
        <tr>
            <td class="label">Tanggal Sidang Akhir</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($report->thesis_exam_date)->format('d F Y') }}</td>
        </tr>
        @endif
        @if($report->thesis_exam_score)
        <tr>
            <td class="label">Nilai Sidang Akhir</td>
            <td class="colon">:</td>
            <td>{{ $report->thesis_exam_score }}</td>
        </tr>
        @endif
        
        <tr><td colspan="3">&nbsp;</td></tr>

        <tr>
            <td class="label">Artikel Jurnal</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->journal_article_status ?? '-')) }}</td>
        </tr>
        <tr>
            <td class="label">Publikasi Jurnal</td>
            <td class="colon">:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $report->journal_publication_status ?? '-')) }}</td>
        </tr>
    </table>


    <div class="section-title">D. AKTIVITAS AKADEMIK LAINNYA</div>
    @if(!empty($report->other_academic_activities) && is_array($report->other_academic_activities))
        <table class="grid-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Aktivitas</th>
                    <th>Tanggal</th>
                    <th>Deskripsi / Peran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->other_academic_activities as $index => $activity)
                    <tr>
                        <td width="30">{{ $index + 1 }}</td>
                        <td>{{ $activity['activity_name'] ?? '-' }}</td>
                        <td width="100">{{ $activity['activity_date'] ? \Carbon\Carbon::parse($activity['activity_date'])->format('d M Y') : '-' }}</td>
                        <td>{{ $activity['activity_description'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="margin-left:10px;"><em>Tidak ada data aktivitas akademik lainnya.</em></p>
    @endif


    <div class="signature-section">
        <div class="signature-box">
            <p>Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p>Peserta Program RPX Scholarship</p>
            
            @if($user->signature_image || $user->signature_pad)
                <div style="margin-top: 10px; margin-bottom: -10px;">
                    @php
                        $sigSrc = '';
                        if ($user->signature_pad) {
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
            @endif
            
            <div class="signature-name">{{ strtoupper($user->name) }}</div>
            <div>NIK. {{ $user->nik ?? '-' }}</div>
        </div>
    </div>

</body>
</html>
