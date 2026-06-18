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

    <div class="signature-section">
        <div class="signature-box">
            Jakarta, {{ now()->translatedFormat('d F Y') }}<br>
            Yang menyetujui,<br>
            <br>
            @if($isApproved && $approver)
                {{-- Priority 1: Signature pad drawn on approval (base64 data) --}}
                @if($application->signature_pad)
                    <img src="{{ $application->signature_pad }}" class="signature-img">
                {{-- Priority 2: Uploaded signature image on approval --}}
                @elseif($application->signature_image)
                    <img src="{{ storage_path('app/public/' . $application->signature_image) }}" class="signature-img">
                {{-- Priority 3: Approver profile signature pad --}}
                @elseif($approver->signature_pad)
                    <img src="{{ $approver->signature_pad }}" class="signature-img">
                {{-- Priority 4: Approver profile signature image --}}
                @elseif($approver->signature_image)
                    <img src="{{ storage_path('app/public/' . $approver->signature_image) }}" class="signature-img">
                @else
                    <br><br><br>
                @endif
            @else
                <br><br><br>
            @endif
            <br>
            {{ $approver->name ?? '....................................' }}
        </div>
    </div>
</body>
</html>
