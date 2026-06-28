@if($pspApplication)
<section class="psp-status py-5">

<div class="container-lg">

    <!-- TITLE -->
    <div class="mb-4">
        <h2 class="fw-semibold">Your PSP Application Process</h2>
    </div>

    @php
        $status = $pspApplication->status; // submission | review | approved | rejected

        $step1Done     = in_array($status, ['submission','review','approved','rejected']);

        // Resolve program study — via scholarship relation or directly from studyPlan
        $progStudy = $pspApplication->scholarship?->programStudy
                  ?? $pspApplication->studyPlan?->programStudy
                  ?? null;
    @endphp

    <!-- PROGRAM STUDY INFO CARD -->
    @if($progStudy)
    <div class="psp-info-card mb-4">
        <div class="psp-info-label">📚 Applied Program Study</div>
        <div class="psp-info-grid">
            <div class="psp-info-item">
                <small>Program</small>
                <strong>{{ $progStudy->name }}</strong>
            </div>
            @if($progStudy->scholarship)
            <div class="psp-info-item">
                <small>Scholarship</small>
                <strong>{{ $progStudy->scholarship }}</strong>
            </div>
            @endif
            @if($progStudy->university)
            <div class="psp-info-item">
                <small>University</small>
                <strong>{{ $progStudy->university }}</strong>
            </div>
            @endif
            @if($progStudy->country)
            <div class="psp-info-item">
                <small>Country</small>
                <strong>{{ $progStudy->country }}</strong>
            </div>
            @endif
            @if($progStudy->competency)
            <div class="psp-info-item">
                <small>Competency</small>
                <strong>{{ $progStudy->competency }}</strong>
            </div>
            @endif
            @if($progStudy->deadline)
            <div class="psp-info-item">
                <small>Deadline</small>
                <strong>{{ $progStudy->deadline->format('d M Y') }}</strong>
            </div>
            @endif
            <div class="psp-info-item">
                <small>Status</small>
                @php $isOpen = !$progStudy->deadline || \Carbon\Carbon::now()->isBefore($progStudy->deadline); @endphp
                <strong style="color: {{ $isOpen ? '#16a34a' : '#dc2626' }}">
                    {{ $isOpen ? '● OPEN' : '✕ CLOSED' }}
                </strong>
            </div>
        </div>
    </div>
    @endif

    <!-- TABLE -->
    <div class="table-responsive psp-wrapper">

        <table class="table psp-table text-center align-middle">

            <!-- HEADER -->
            <thead>
                <tr>
                    <th>Submission</th>
                    <th>Unit Leader Approval</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                <tr>

                    <!-- STEP 1: Submission (always done once submitted) -->
                    <td class="step {{ $step1Done ? 'done' : 'pending' }}">
                        <div class="step-inner">
                            <div class="icon {{ $step1Done ? 'done-icon' : 'pending-icon' }}">
                                {{ $step1Done ? '✓' : '•' }}
                            </div>
                            <div class="status-title">{{ $step1Done ? 'Submitted' : 'Waiting' }}</div>
                            @if($step1Done)
                                <div class="status-desc text-muted" style="font-size:12px;">
                                    {{ $pspApplication->created_at->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- STEP 2: Unit Leader Approval -->
                    <td class="step
                        {{ in_array($status, ['rejected', 'review']) ? 'revision' : ($status === 'approved' ? 'done' : 'pending') }}">
                        <div class="step-inner">
                            @if($status === 'rejected')
                                <div class="icon revision-icon">!</div>
                                <div class="status-title" style="color:#ef4444;">Rejected</div>
                                <div class="status-desc">
                                    {{ $pspApplication->notes ?? 'Your application was not approved. Please check the notes.' }}
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <a href="{{ route('psp.letter', $pspApplication->id) }}" class="btn-download" target="_blank">
                                        ⬇ Download Rejection Letter
                                    </a>
                                    {{-- <form action="{{ route('psp.letter.send', $pspApplication->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-download" style="background:#f0f9ff; border-color:#0284c7; color:#0284c7;">
                                            <i class="bi bi-envelope"></i> Send to Email
                                        </button>
                                    </form> --}}
                                </div>
                            @elseif($status === 'approved')
                                <div class="icon done-icon">✓</div>
                                <div class="status-title">Approved</div>
                                @if($pspApplication->approver)
                                    <div class="status-desc text-muted" style="font-size:12px;">
                                        by {{ $pspApplication->approver->name }}
                                    </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <a href="{{ route('psp.letter', $pspApplication->id) }}" class="btn-download" target="_blank">
                                        ⬇ Download Approval Letter
                                    </a>
                                </div>
                            @elseif($status === 'review')
                                <div class="icon revision-icon">⟳</div>
                                <div class="status-title">Revision</div>
                                <div class="status-desc" style="color:#f97316;">
                                    {{ $pspApplication->notes ?? 'Your study plan requires revision. Please check the notes.' }}
                                </div>
                            @else
                                <div class="icon pending-icon">•</div>
                                <div class="status-title">Waiting</div>
                            @endif
                        </div>
                    </td>

                </tr>
            </tbody>

        </table>

    </div>

    <!-- NOTE -->
    <div class="mt-3 text-muted small">
        * Approval letter is available after reaching Unit Leader approval stage.
    </div>

</div>

<style>

/* ================= INFO CARD ================= */
.psp-info-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
.psp-info-label {
    font-size: 13px;
    font-weight: 700;
    color: #8b0000;
    margin-bottom: 14px;
    letter-spacing: 0.3px;
}
.psp-info-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.psp-info-item {
    background: #fdf2f2;
    border-radius: 12px;
    padding: 10px 16px;
    min-width: 130px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.psp-info-item small {
    font-size: 10px;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.psp-info-item strong {
    font-size: 13px;
    color: #1a1a2e;
}

/* ================= WRAPPER ================= */
.psp-wrapper {
    border: 1px solid #d1d5db;
    border-radius: 4px;
    overflow: hidden;
}

/* ================= TABLE ================= */
.psp-table {
    border-collapse: collapse;
    margin: 0;
}

/* HEADER */
.psp-table thead th {
    background: #8b0000;
    color: #fff;
    font-weight: 600;
    padding: 16px;
    border-right: 1px solid rgba(255,255,255,0.2);
}

.psp-table thead th:last-child {
    border-right: none;
}

/* BODY CELL */
.psp-table td {
    height: 260px;
    border-top: 1px solid #e5e7eb;
    border-right: 1px solid #e5e7eb;
    padding: 0;
    width: 50%;
}

.psp-table td:last-child {
    border-right: none;
}

/* INNER CONTENT */
.step-inner {
    padding: 30px 20px;
}

/* ================= ICON ================= */
.psp-table .icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 600;
    border: 2px solid #d1d5db;
    color: #555;
}

/* ================= TEXT ================= */
.psp-table .status-title {
    font-weight: 600;
    font-size: 16px;
}

.psp-table .status-desc {
    font-size: 14px;
    color: #444;
    margin-bottom: 12px;
    margin-top: 6px;
}

/* ================= STATE ================= */

/* DONE */
.done { background: #f0fdf4; }
.done-icon { border-color: #22c55e !important; color: #22c55e !important; }

/* REVISION */
.revision { background: #fff7ed; }
.revision-icon { border-color: #f97316 !important; color: #f97316 !important; }

/* PENDING */
.pending { background: #f9fafb; }
.pending-icon { border-color: #9ca3af !important; color: #9ca3af !important; }

/* ================= BUTTON ================= */
.btn-download {
    padding: 6px 14px;
    border: 1px solid #8b0000;
    background: transparent;
    color: #8b0000;
    font-size: 12px;
    cursor: pointer;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.btn-download:hover {
    background: #8b0000;
    color: #fff;
}

/* ================= HOVER EFFECT ================= */
.psp-table td:hover {
    background: rgba(0,0,0,0.01);
    transition: 0.2s;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {

    .psp-table thead {
        display: none;
    }

    .psp-table td {
        display: block;
        height: auto;
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
        width: 100%;
    }

}

</style>

</section>
@else
{{-- No application yet — encourage user to submit --}}
<section class="psp-status py-4">
    <div class="container-lg">
        <div style="background:#f9fafb; border:1px dashed #d1d5db; border-radius:16px; padding:32px; text-align:center;">
            <p style="color:#6b7280; font-size:15px; margin:0;">
                📋 You haven't submitted a study plan yet. Fill in the form above to start your PSP application.
            </p>
        </div>
    </div>
</section>
@endif