@if($pspApplication)
<section class="psp-status py-5">

<div class="container-lg">

    <!-- TITLE -->
    <div class="mb-4">
        <h2 class="fw-semibold">Your PSP Application Process</h2>
    </div>

    @php
        $stage = $pspApplication->approval_stage ?? 0;
        $status = $pspApplication->status; // submission | review | approved | rejected

        $step1Done = true;
        
        $step2Done = $stage >= 1;
        $step2Rejected = $stage == 0 && $status == 'rejected';
        $step2Review = $stage == 0 && $status == 'review';
        
        $step3Done = $stage >= 2;
        $step3Rejected = $stage == 1 && $status == 'rejected';
        $step3Review = $stage == 1 && $status == 'review';
        
        $step4Done = $stage == 3;
        $step4Rejected = $stage == 2 && $status == 'rejected';
        $step4Review = $stage == 2 && $status == 'review';

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
                    <th style="width: 25%">Submission</th>
                    <th style="width: 25%">Dept. Approval</th>
                    <th style="width: 25%">Group Approval</th>
                    <th style="width: 25%">Dir. Approval</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                <tr>

                    <!-- STEP 1: Submission -->
                    <td class="step done">
                        <div class="step-inner">
                            <div class="icon done-icon">✓</div>
                            <div class="status-title">Submitted</div>
                            <div class="status-desc text-muted" style="font-size:12px;">
                                {{ $pspApplication->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </td>

                    <!-- STEP 2: Department Approval -->
                    @php
                        $step2Class = 'pending';
                        if ($step2Done) $step2Class = 'done';
                        elseif ($step2Rejected) $step2Class = 'revision';
                        elseif ($step2Review) $step2Class = 'revision';
                    @endphp
                    <td class="step {{ $step2Class }}">
                        <div class="step-inner">
                            @if($step2Done)
                                <div class="icon done-icon">✓</div>
                                <div class="status-title">Approved</div>
                                @if($pspApplication->departmentApprover)
                                    <div class="status-desc text-muted" style="font-size:12px;">
                                        by {{ $pspApplication->departmentApprover->name }}
                                    </div>
                                @endif
                            @elseif($step2Rejected)
                                <div class="icon revision-icon">!</div>
                                <div class="status-title" style="color:#ef4444;">Rejected</div>
                                <div class="status-desc">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
                                </div>
                            @elseif($step2Review)
                                <div class="icon revision-icon">⟳</div>
                                <div class="status-title">Revision</div>
                                <div class="status-desc" style="color:#f97316;">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
                                </div>
                            @else
                                <div class="icon pending-icon">•</div>
                                <div class="status-title">Waiting</div>
                            @endif
                        </div>
                    </td>

                    <!-- STEP 3: Group Approval -->
                    @php
                        $step3Class = 'pending';
                        if ($step3Done) $step3Class = 'done';
                        elseif ($step3Rejected) $step3Class = 'revision';
                        elseif ($step3Review) $step3Class = 'revision';
                    @endphp
                    <td class="step {{ $step3Class }}">
                        <div class="step-inner">
                            @if($step3Done)
                                <div class="icon done-icon">✓</div>
                                <div class="status-title">Approved</div>
                                @if($pspApplication->groupApprover)
                                    <div class="status-desc text-muted" style="font-size:12px;">
                                        by {{ $pspApplication->groupApprover->name }}
                                    </div>
                                @endif
                            @elseif($step3Rejected)
                                <div class="icon revision-icon">!</div>
                                <div class="status-title" style="color:#ef4444;">Rejected</div>
                                <div class="status-desc">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
                                </div>
                            @elseif($step3Review)
                                <div class="icon revision-icon">⟳</div>
                                <div class="status-title">Revision</div>
                                <div class="status-desc" style="color:#f97316;">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
                                </div>
                            @else
                                <div class="icon pending-icon">•</div>
                                <div class="status-title">Waiting</div>
                            @endif
                        </div>
                    </td>

                    <!-- STEP 4: Direktorat Approval -->
                    @php
                        $step4Class = 'pending';
                        if ($step4Done) $step4Class = 'done';
                        elseif ($step4Rejected) $step4Class = 'revision';
                        elseif ($step4Review) $step4Class = 'revision';
                    @endphp
                    <td class="step {{ $step4Class }}">
                        <div class="step-inner">
                            @if($step4Done)
                                <div class="icon done-icon">✓</div>
                                <div class="status-title">Approved</div>
                                @if($pspApplication->direktoratApprover)
                                    <div class="status-desc text-muted" style="font-size:12px;">
                                        by {{ $pspApplication->direktoratApprover->name }}
                                    </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <a href="{{ route('psp.letter', $pspApplication->id) }}" class="btn-download" target="_blank">
                                        ⬇ Download Approval Letter
                                    </a>
                                </div>
                            @elseif($step4Rejected)
                                <div class="icon revision-icon">!</div>
                                <div class="status-title" style="color:#ef4444;">Rejected</div>
                                <div class="status-desc">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <a href="{{ route('psp.letter', $pspApplication->id) }}" class="btn-download" target="_blank">
                                        ⬇ Download Rejection Letter
                                    </a>
                                </div>
                            @elseif($step4Review)
                                <div class="icon revision-icon">⟳</div>
                                <div class="status-title">Revision</div>
                                <div class="status-desc" style="color:#f97316;">
                                    {{ $pspApplication->notes ?? 'Check notes.' }}
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
        * Approval letter is available after reaching final Direktorat approval stage or if rejected.
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
    width: 25%;
}

.psp-table td:last-child {
    border-right: none;
}

/* INNER CONTENT */
.step-inner {
    padding: 30px 10px;
}

/* ================= ICON ================= */
.psp-table .icon {
    width: 50px;
    height: 50px;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 600;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    color: #555;
}

/* ================= TEXT ================= */
.psp-table .status-title {
    font-weight: 600;
    font-size: 14px;
}

.psp-table .status-desc {
    font-size: 12px;
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
    font-size: 11px;
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