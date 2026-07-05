<section class="sa-section">

    {{-- ══════ HERO BANNER ══════ --}}
    <div class="sa-hero" style="background: linear-gradient(135deg, #991b1b, #dc2626);">
        <div class="sa-hero-orb sa-hero-orb-1" style="background: rgba(255,255,255,0.1)"></div>
        <div class="sa-hero-orb sa-hero-orb-2" style="background: rgba(255,255,255,0.05)"></div>
        <div class="sa-hero-inner">
            <div class="sa-hero-text">
                <span class="sa-hero-eyebrow">
                    <i class="bi bi-journal-check"></i> Study Progress
                </span>
                <h1>Study Progress Report</h1>
                <p>Record, track, and manage your semester study reports in one place.</p>
            </div>

            <div class="sa-hero-right">
                {{-- Stats in hero --}}
                <div class="sa-hero-stats">
                    <div class="sa-hero-stat">
                        <span class="sa-stat-val">{{ $statsTotal }}</span>
                        <span class="sa-stat-lbl">Total</span>
                    </div>
                    <div class="sa-hero-divider"></div>
                    <div class="sa-hero-stat">
                        <span class="sa-stat-val" style="color:#6ee7b7">{{ $statsApproved }}</span>
                        <span class="sa-stat-lbl">Approved</span>
                    </div>
                    <div class="sa-hero-divider"></div>
                    <div class="sa-hero-stat">
                        <span class="sa-stat-val" style="color:#fde68a">{{ $statsRevision }}</span>
                        <span class="sa-stat-lbl">Revision</span>
                    </div>
                    <div class="sa-hero-divider"></div>
                    <div class="sa-hero-stat">
                        <span class="sa-stat-val" style="color:#fca5a5">{{ $statsRejected }}</span>
                        <span class="sa-stat-lbl">Rejected</span>
                    </div>
                </div>

                {{-- Add Report Button --}}
                @if($pspApp && $pspApp->status === 'approved')
                    <a href="{{ route('study-progress-report.create') }}" class="sa-btn-add" style="text-decoration: none;">
                        <i class="bi bi-plus-lg"></i> Fill Next Semester Report
                    </a>
                @else
                    <button class="sa-btn-add sa-btn-add--locked" disabled title="PSP must be approved first">
                        <i class="bi bi-lock-fill"></i> Fill Report
                    </button>
                @endif
            </div>
        </div>
    </div>

<div class="container-lg sa-container">

    @if(!$pspApp || $pspApp->status !== 'approved')
        <div style="background:#fffbeb; border:1px solid #fde68a; color:#b45309; padding:1.75rem 2rem; border-radius:16px; margin:2rem 0; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
            <i class="bi bi-shield-lock-fill" style="font-size:2.5rem; display:block; margin-bottom:0.75rem;"></i>
            <h4 style="margin-bottom:0.6rem; font-weight:700;">Access Restricted</h4>
            <p style="margin-bottom:1.25rem; font-size:1rem; max-width:460px; margin-left:auto; margin-right:auto;">
                You must complete your <strong>PSP Application</strong> and wait for leadership approval before you can submit study progress reports.
            </p>
            <a href="{{ route('psp') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg,#c0392b,#e74c3c); color:#fff; padding:0.65rem 1.5rem; border-radius:10px; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(192,57,43,0.3);">
                Go to PSP Application <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="sa-alert sa-alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if($errors->has('error'))
        <div class="sa-alert sa-alert-error"><i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first('error') }}</div>
    @endif

    {{-- APPLICATION LIST --}}
    @if($applications->isEmpty())
        <div class="sa-empty">
            <i class="bi bi-journal-x"></i>
            <p>No study progress report data yet.</p>
        </div>
    @else
        <div class="sa-list">
            @foreach($applications as $app)
            <div class="sa-card {{ $app->status === 'approved' ? 'lolos' : ($app->status === 'revisi' ? 'pending' : ($app->status === 'rejected' ? 'tidak_lolos' : 'pending')) }}">
                {{-- Card Header --}}
                <div class="sa-card-header">
                    <div class="sa-card-title">
                        <span class="sa-badge status-{{ $app->status === 'approved' ? 'lolos' : ($app->status === 'revisi' ? 'pending' : ($app->status === 'rejected' ? 'tidak_lolos' : 'pending')) }}">
                            @if($app->status === 'approved') <i class="bi bi-check-circle-fill"></i>
                            @elseif($app->status === 'rejected') <i class="bi bi-x-circle-fill"></i>
                            @else <i class="bi bi-hourglass-split"></i> @endif
                            {{ ucfirst($app->status) }}
                        </span>
                        <h4>Semester {{ $app->semester }}</h4>
                        <div class="sa-card-meta">
                            <span><i class="bi bi-star"></i> GPA: {{ $app->gpa }} / {{ $app->max_gpa }}</span>
                            @if($app->thesis_title)
                                <span><i class="bi bi-book"></i> Thesis: {{ Str::limit($app->thesis_title, 30) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="sa-card-actions">
                        @if($app->status === 'revisi' || $app->status === 'rejected')
                            <a href="{{ route('study-progress-report.edit', $app->id) }}" class="sa-btn-expand" style="text-decoration: none;">
                                <i class="bi bi-pencil-square"></i> Edit / Revise
                            </a>
                        @else
                            <a href="{{ route('study-progress-report.pdf', $app->id) }}" target="_blank" class="sa-btn-expand" style="text-decoration: none;">
                                <i class="bi bi-file-earmark-pdf"></i> View PDF
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Rejection / Revision Note --}}
                @if($app->notes_pimpinan)
                <div class="sa-success-cta" style="background: {{ $app->status === 'revisi' ? '#fffbeb' : '#fef2f2' }}; border: 1px solid {{ $app->status === 'revisi' ? '#fde68a' : '#fecaca' }};">
                    <div class="sa-success-icon" style="background: {{ $app->status === 'revisi' ? '#fef3c7' : '#fee2e2' }}; color: {{ $app->status === 'revisi' ? '#d97706' : '#dc2626' }};">
                        {{ $app->status === 'revisi' ? '⚠️' : '❌' }}
                    </div>
                    <div class="sa-success-content">
                        <h5 style="color: {{ $app->status === 'revisi' ? '#b45309' : '#991b1b' }};">Catatan Pimpinan</h5>
                        <p style="color: {{ $app->status === 'revisi' ? '#92400e' : '#7f1d1d' }};">{{ $app->notes_pimpinan }}</p>
                    </div>
                    @if($app->status === 'revisi' || $app->status === 'rejected')
                        <a href="{{ route('study-progress-report.edit', $app->id) }}" class="sa-btn-continue-fp" style="background: {{ $app->status === 'revisi' ? '#d97706' : '#dc2626' }}; border-color: {{ $app->status === 'revisi' ? '#d97706' : '#dc2626' }};">
                            Perbaiki Laporan <i class="bi bi-arrow-repeat"></i>
                        </a>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif
    @endif
</div>

{{-- CSS KHUSUS --}}
<style>
/* CSS dari scholarship, kita copas beberapa agar sama persis desainnya */
.sa-section {
    background-color: #f8fafc;
    min-height: calc(100vh - 80px);
    padding-bottom: 4rem;
}
.sa-hero {
    position: relative;
    background: linear-gradient(135deg, #991b1b, #dc2626);
    padding: calc(3rem + 80px) 0 3rem 0;
    overflow: hidden;
}
.sa-hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    z-index: 0;
}
.sa-hero-orb-1 { width: 300px; height: 300px; top: -100px; right: -50px; }
.sa-hero-orb-2 { width: 200px; height: 200px; bottom: -50px; left: 10%; }
.sa-hero-inner {
    position: relative;
    z-index: 1;
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}
@media(max-width:991px) {
    .sa-hero-inner { flex-direction: column; text-align: center; }
}
.sa-hero-eyebrow {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: #fff;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 1rem;
}
.sa-hero-text h1 {
    color: #ffffff;
    font-weight: 800;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}
.sa-hero-text p {
    color: rgba(255,255,255,0.8);
    font-size: 1.1rem;
    max-width: 500px;
    margin: 0;
}
.sa-hero-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1.5rem;
}
@media(max-width:991px) {
    .sa-hero-right { align-items: center; }
    .sa-hero-text p { margin: 0 auto; }
}
.sa-hero-stats {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}
.sa-hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.2;
}
.sa-stat-val { font-size: 1.5rem; font-weight: 800; color: #fff; }
.sa-stat-lbl { font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,0.7); text-transform: uppercase; }
.sa-hero-divider { width: 1px; height: 30px; background: rgba(255,255,255,0.2); }

.sa-btn-add {
    background: #fff;
    color: #991b1b;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}
.sa-btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); color: #991b1b; }
.sa-btn-add--locked { background: rgba(255,255,255,0.5); color: rgba(0,0,0,0.4); cursor: not-allowed; box-shadow: none; }

.sa-container { max-width: 1140px; margin-top: 2rem; }

.sa-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
}
.sa-empty i { font-size: 3rem; color: #94a3b8; display: block; margin-bottom: 1rem; }
.sa-empty p { color: #64748b; font-size: 1.1rem; margin: 0; }

.sa-list { display: flex; flex-direction: column; gap: 1rem; }
.sa-card {
    background: #fff;
    border-radius: 16px;
    border-left: 4px solid #cbd5e1;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    transition: all 0.2s;
    overflow: hidden;
}
.sa-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
.sa-card.lolos { border-left-color: #10b981; }
.sa-card.pending { border-left-color: #f59e0b; }
.sa-card.tidak_lolos { border-left-color: #ef4444; }

.sa-card-header {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    border-bottom: 1px solid #f1f5f9;
}
@media(max-width:768px) {
    .sa-card-header { flex-direction: column; align-items: flex-start; }
    .sa-card-actions { width: 100%; display: flex; justify-content: flex-end; }
}

.sa-card-title { flex: 1; }
.sa-card-title h4 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0.5rem 0; }
.sa-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.85rem;
    color: #64748b;
}
.sa-card-meta span { display: inline-flex; align-items: center; gap: 0.35rem; }

.sa-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}
.sa-badge.status-lolos { background: #d1fae5; color: #065f46; }
.sa-badge.status-pending { background: #fef3c7; color: #92400e; }
.sa-badge.status-tidak_lolos { background: #fee2e2; color: #991b1b; }

.sa-card-actions { display: flex; gap: 0.5rem; align-items: center; }
.sa-btn-expand {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
}
.sa-btn-expand:hover { background: #e2e8f0; color: #1e293b; }

.sa-success-cta {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    background: #f0fdf4;
    gap: 1.5rem;
}
@media(max-width:768px) {
    .sa-success-cta { flex-direction: column; align-items: flex-start; text-align: left; }
    .sa-btn-continue-fp { width: 100%; justify-content: center; }
}
.sa-success-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #d1fae5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.sa-success-content { flex: 1; }
.sa-success-content h5 { margin: 0 0 0.25rem 0; font-weight: 700; color: #166534; font-size: 1.1rem; }
.sa-success-content p { margin: 0; font-size: 0.9rem; color: #15803d; }
.sa-btn-continue-fp {
    background: #10b981;
    color: #fff;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    border: 1px solid #10b981;
    white-space: nowrap;
}
.sa-btn-continue-fp:hover { background: #059669; color: #fff; }
</style>
</section>
