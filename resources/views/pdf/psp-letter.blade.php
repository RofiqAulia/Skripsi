<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat PSP</title>
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
            margin-bottom: 40px; 
            text-transform: uppercase; 
        }
        .section-title { 
            font-weight: bold; 
            margin-bottom: 12px; 
            margin-top: 25px; 
            font-size: 13px; 
        }
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            margin-left: 20px; 
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
        .study-plan-text { 
            margin-left: 20px; 
            text-align: justify; 
            white-space: pre-wrap;
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
        .signature-img { 
            max-height: 80px; 
            max-width: 180px; 
            display: block; 
            margin: 10px auto; 
        }
        .sig-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 2px solid #000;
            padding-top: 6px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #000;
        }
        .sig-footer .company-name {
            font-weight: bold;
            font-size: 11px;
        }
    </style>
</head>
<body>
    @php
        $isApproved = $application->status === 'approved';
        $statusText = 'PENOLAKAN';
        if ($application->status === 'approved') $statusText = 'PERSETUJUAN';
        elseif ($application->status === 'review') $statusText = 'REVISI';
        
        $user       = $application->user;
        $studyPlan  = $application->studyPlan;
        $program    = $studyPlan?->programStudy;
        $scholarship = $application->scholarship ?? $studyPlan?->scholarship ?? $program?->scholarships?->first();
        $approver   = $application->approver;
    @endphp

    @if(file_exists(public_path('images/logo/sig-latar-putih.png')))
        <img src="{{ public_path('images/logo/sig-latar-putih.png') }}" class="logo" alt="SIG Logo">
    @elseif(file_exists(public_path('images/sig-latar-putih.png')))
        <img src="{{ public_path('images/sig-latar-putih.png') }}" class="logo" alt="SIG Logo">
    @else
        <h2 style="color:#8b0000; margin-bottom:30px;">SIG</h2>
    @endif

    <div class="title">
        SURAT {{ $statusText }} PERSONALIZE STUDY PLAN (PSP)
    </div>

    <div class="section-title">Biodata</div>
    <table class="data-table">
        <tr>
            <td class="label">Name</td>
            <td class="colon">:</td>
            <td>{{ $user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td class="colon">:</td>
            <td>{{ $user->email ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Position</td>
            <td class="colon">:</td>
            <td>{{ $user->position ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Company</td>
            <td class="colon">:</td>
            <td>{{ $user->company ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Applied Scholarship Details</div>
    <table class="data-table">
        <tr>
            <td class="label">Program study</td>
            <td class="colon">:</td>
            <td>{{ $program?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Scholarship</td>
            <td class="colon">:</td>
            <td>{{ $program?->scholarship ?? $scholarship?->title ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">University</td>
            <td class="colon">:</td>
            <td>{{ $program?->university ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Country</td>
            <td class="colon">:</td>
            <td>{{ $program?->country ?? $scholarship?->country ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Research Topic</div>
    <div class="study-plan-text">{{ $application->study_plan_text ?? ($studyPlan?->future_competence ?? '-') }}</div>

    <table style="width: 100%; margin-top: 60px; text-align: center; border-collapse: collapse;">
        <tr>
            <!-- Department Approver -->
            <td style="width: 33%; vertical-align: top; padding: 0 10px;">
                Jakarta, {{ $application->department_approved_at ? \Carbon\Carbon::parse($application->department_approved_at)->translatedFormat('d F Y') : '..............................' }}<br>
                Yang menyetujui,<br>
                <strong>GM of {{ $application->user->department?->name ?? '.....................' }}</strong><br>
                
                @if($application->departmentApprover)
                    @if($application->departmentApprover->signature_pad)
                        <img src="{{ $application->departmentApprover->signature_pad }}" class="signature-img" style="max-height:60px;">
                    @elseif($application->departmentApprover->signature_image)
                        <img src="{{ storage_path('app/public/' . $application->departmentApprover->signature_image) }}" class="signature-img" style="max-height:60px;">
                    @else
                        <br><br><br><br>
                    @endif
                @else
                    <br><br><br><br>
                @endif
                
                <u>{{ $application->departmentApprover?->name ?? '....................................' }}</u>
            </td>

            <!-- Group Approver -->
            <td style="width: 33%; vertical-align: top; padding: 0 10px;">
                Jakarta, {{ $application->group_approved_at ? \Carbon\Carbon::parse($application->group_approved_at)->translatedFormat('d F Y') : '..............................' }}<br>
                Yang menyetujui,<br>
                <strong>SVP of {{ $application->user->department?->group?->name ?? '.....................' }}</strong><br>
                
                @if($application->groupApprover)
                    @if($application->groupApprover->signature_pad)
                        <img src="{{ $application->groupApprover->signature_pad }}" class="signature-img" style="max-height:60px;">
                    @elseif($application->groupApprover->signature_image)
                        <img src="{{ storage_path('app/public/' . $application->groupApprover->signature_image) }}" class="signature-img" style="max-height:60px;">
                    @else
                        <br><br><br><br>
                    @endif
                @else
                    <br><br><br><br>
                @endif
                
                <u>{{ $application->groupApprover?->name ?? '....................................' }}</u>
            </td>

            <!-- Direktorat Approver -->
            <td style="width: 33%; vertical-align: top; padding: 0 10px;">
                Jakarta, {{ $application->direktorat_approved_at ? \Carbon\Carbon::parse($application->direktorat_approved_at)->translatedFormat('d F Y') : '..............................' }}<br>
                Yang menyetujui,<br>
                <strong>Direktur of {{ $application->user->department?->group?->direktorat?->name ?? '.....................' }}</strong><br>
                
                @if($isApproved)
                    @if($application->signature_pad)
                        <img src="{{ $application->signature_pad }}" class="signature-img" style="max-height:60px;">
                    @elseif($application->signature_image)
                        <img src="{{ storage_path('app/public/' . $application->signature_image) }}" class="signature-img" style="max-height:60px;">
                    @elseif($application->direktoratApprover && $application->direktoratApprover->signature_pad)
                        <img src="{{ $application->direktoratApprover->signature_pad }}" class="signature-img" style="max-height:60px;">
                    @elseif($application->direktoratApprover && $application->direktoratApprover->signature_image)
                        <img src="{{ storage_path('app/public/' . $application->direktoratApprover->signature_image) }}" class="signature-img" style="max-height:60px;">
                    @else
                        <br><br><br><br>
                    @endif
                @else
                    <br><br><br><br>
                @endif
                
                <u>{{ $application->direktoratApprover?->name ?? '....................................' }}</u>
            </td>
        </tr>
    </table>

    <!-- SIG Footer -->
    <div class="sig-footer">
        <div class="company-name">PT Semen Indonesia (Persero) Tbk.</div>
        <div>South Quarter Tower A Lt. 19-20 Jl. RA Kartini Kav. 8, Jakarta Selatan 12430, Indonesia &nbsp; <strong>p.</strong> +62 21 5261174-5 &nbsp; <strong>f.</strong> +62 21 5261176 &nbsp; <strong>www.sig.id</strong></div>
    </div>
</body>
</html>
