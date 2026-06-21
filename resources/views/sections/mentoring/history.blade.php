<section class="section-history">
<div class="container-lg">

    <div class="history-header">
        <div>
            <h2><i class="bi bi-clock-history"></i> Session History</h2>
            <p>Track all your mentoring sessions and their status.</p>
        </div>
        <a href="{{ route('mentoring') }}" class="btn-back-mentoring">
            <i class="bi bi-arrow-left"></i> Back to Mentoring
        </a>
    </div>

    @if($mySessions->isEmpty())
        <div class="history-empty">
            <div class="he-icon"><i class="bi bi-journal-x"></i></div>
            <h4>No Sessions Yet</h4>
            <p>You haven't booked any mentoring sessions. Start by choosing a mentor and scheduling a session.</p>
            <a href="{{ route('mentoring') }}" class="btn-start-mentoring">
                <i class="bi bi-arrow-right"></i> Go to Mentoring
            </a>
        </div>
    @else

    <!-- STATS BAR -->
    <div class="history-stats">
        <div class="hs-item">
            <span class="hs-num">{{ $mySessions->count() }}</span>
            <span class="hs-label">Total Sessions</span>
        </div>
        <div class="hs-item">
            <span class="hs-num hs-green">{{ $mySessions->where('status', 'done')->count() }}</span>
            <span class="hs-label">Completed</span>
        </div>
        <div class="hs-item">
            <span class="hs-num hs-amber">{{ $mySessions->where('status', 'pending')->count() }}</span>
            <span class="hs-label">Pending</span>
        </div>
        <div class="hs-item">
            <span class="hs-num hs-red">{{ $mySessions->where('status', 'cancelled')->count() }}</span>
            <span class="hs-label">Cancelled</span>
        </div>
    </div>

    <!-- SESSION CARDS -->
    <div class="history-list">
        @foreach($mySessions as $session)
        <div class="history-card">

            <div class="hc-left">
                <div class="hc-date-box">
                    <span class="hc-day">{{ \Carbon\Carbon::parse($session->schedule->date)->format('d') }}</span>
                    <span class="hc-month">{{ \Carbon\Carbon::parse($session->schedule->date)->format('M') }}</span>
                    <span class="hc-year">{{ \Carbon\Carbon::parse($session->schedule->date)->format('Y') }}</span>
                </div>
            </div>

            <div class="hc-content">

                <div class="hc-top">
                    <div class="hc-session-info">
                        <h5>Session #{{ $session->id }}</h5>
                        <form method="POST" action="{{ route('mentoring.session.update-status', $session->id) }}" class="d-inline-block">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="hc-badge-select hc-{{ $session->status }}">
                                <option value="pending" {{ $session->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="done" {{ $session->status === 'done' ? 'selected' : '' }}>🎉 Done</option>
                                <option value="cancelled" {{ $session->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="hc-details">
                    <div class="hc-detail-item">
                        <i class="bi bi-clock"></i>
                        <span>
                            {{ \Carbon\Carbon::parse($session->schedule->start_time)->format('H:i') }}
                            @if($session->schedule->end_time)
                                - {{ \Carbon\Carbon::parse($session->schedule->end_time)->format('H:i') }}
                            @endif
                        </span>
                    </div>
                    <div class="hc-detail-item">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ \Carbon\Carbon::parse($session->schedule->date)->format('l, d F Y') }}</span>
                    </div>
                    <div class="hc-detail-item">
                        <i class="bi bi-person"></i>
                        <span>{{ $session->mentor->user->name }}</span>
                    </div>
                    @if($session->link_meet)
                    <div class="hc-detail-item">
                        <i class="bi bi-camera-video"></i>
                        <a href="{{ $session->link_meet }}" target="_blank" class="hc-link">{{ Str::limit($session->link_meet, 45) }}</a>
                    </div>
                    @endif
                </div>

                @if($session->report)
                <div class="hc-report">
                    <span class="hc-report-badge hc-report-approved">
                        <i class="bi bi-file-earmark-text"></i>
                        Report Submitted
                    </span>
                </div>
                @endif

            </div>

        </div>
        @endforeach
    </div>

    @endif

</div>
</section>

<style>
/* ═══ BASE ═══ */
.section-history {
    background: #f4f6f9;
    padding: 40px 0 60px;
    min-height: 60vh;
}

/* ═══ HEADER ═══ */
.history-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
}

.history-header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #111;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.history-header h2 i { color: #8b0000; }

.history-header p {
    font-size: 15px;
    color: #6b7280;
    margin: 4px 0 0;
}

.btn-back-mentoring {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: .2s;
}

.btn-back-mentoring:hover {
    border-color: #8b0000;
    color: #8b0000;
    transform: translateY(-2px);
}

/* ═══ EMPTY STATE ═══ */
.history-empty {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
}

.he-icon { font-size: 48px; color: #d1d5db; margin-bottom: 16px; }
.history-empty h4 { color: #374151; font-size: 18px; margin-bottom: 8px; }
.history-empty p { color: #9ca3af; font-size: 14px; margin-bottom: 20px; }

.btn-start-mentoring {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: .2s;
}

.btn-start-mentoring:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139,0,0,.3);
    color: #fff;
}

/* ═══ STATS BAR ═══ */
.history-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}

.hs-item {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
}

.hs-num {
    display: block;
    font-size: 28px;
    font-weight: 700;
    color: #111;
    line-height: 1.1;
}

.hs-num.hs-green { color: #16a34a; }
.hs-num.hs-amber { color: #d97706; }
.hs-num.hs-blue { color: #2563eb; }

.hs-label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 4px;
}

/* ═══ SESSION CARDS ═══ */
.history-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.history-card {
    display: flex;
    gap: 20px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 20px;
    transition: .2s;
}

.history-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,.05);
    border-color: rgba(139,0,0,.1);
}

/* DATE BOX */
.hc-left { flex-shrink: 0; }

.hc-date-box {
    width: 64px;
    text-align: center;
    background: linear-gradient(135deg, #8b0000, #c40000);
    border-radius: 12px;
    padding: 12px 8px;
    color: #fff;
}

.hc-day {
    display: block;
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
}

.hc-month {
    display: block;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 2px;
}

.hc-year {
    display: block;
    font-size: 10px;
    opacity: .7;
}

/* CONTENT */
.hc-content { flex: 1; min-width: 0; }

.hc-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.hc-session-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.hc-session-info h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

/* BADGES & SELECTS */
.hc-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.hc-badge-select {
    font-size: 11px;
    font-weight: 600;
    padding: 5px 28px 5px 12px;
    border-radius: 50px;
    border: 1px solid transparent;
    cursor: pointer;
    outline: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 10px 10px;
    transition: all 0.2s ease;
    display: inline-block;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234b5563' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
}

.hc-badge-select:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-color: rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.hc-pending { background-color: #fef3c7; color: #d97706; }
.hc-done { background-color: #dcfce7; color: #16a34a; }
.hc-cancelled { background-color: #fee2e2; color: #dc2626; }

/* DETAILS */
.hc-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.hc-detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #6b7280;
}

.hc-detail-item i {
    font-size: 14px;
    color: #9ca3af;
    flex-shrink: 0;
}

.hc-link {
    color: #2563eb;
    text-decoration: none;
    font-size: 13px;
}

.hc-link:hover { text-decoration: underline; }

/* REPORT */
.hc-report {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #f3f4f6;
}

.hc-report-badge {
    font-size: 12px;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.hc-report-submitted { background: #e0e7ff; color: #4f46e5; }
.hc-report-approved { background: #dcfce7; color: #16a34a; }
.hc-report-revision { background: #fef3c7; color: #d97706; }
.hc-report-rejected { background: #fee2e2; color: #dc2626; }
.hc-report-draft { background: #f3f4f6; color: #9ca3af; }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
    .history-header { flex-direction: column; }
    .history-stats { grid-template-columns: repeat(2, 1fr); }
    .hc-details { grid-template-columns: 1fr; }
    .history-card { flex-direction: column; gap: 12px; }
    .hc-date-box { display: flex; gap: 8px; align-items: baseline; width: auto; padding: 8px 14px; }
}
</style>
