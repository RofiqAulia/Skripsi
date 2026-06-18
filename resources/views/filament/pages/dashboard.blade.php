<x-filament-panels::page>

@php
    use App\Models\ScholarshipApplication;
    use App\Models\PspApplication;

    // ── KPI Overview ──
    $saTotal  = ScholarshipApplication::count();
    $saLolos  = ScholarshipApplication::where('status', 'lolos')->count();
    $saPending = ScholarshipApplication::where('status', 'pending')->count();
    $saTidakLolos = ScholarshipApplication::where('status', 'tidak_lolos')->count();
    $successRate = $saTotal > 0 ? round($saLolos / $saTotal * 100, 1) : 0;

    // Mentee PSP approved & lolos beasiswa (cross-table insight)
    $pspAndLolos = ScholarshipApplication::where('status', 'lolos')
        ->whereNotNull('psp_application_id')
        ->whereHas('pspApplication', fn($q) => $q->where('status', 'approved'))
        ->count();

    // ── Per Negara ──
    $byCountry = ScholarshipApplication::join('scholarships', 'scholarship_applications.scholarship_id', '=', 'scholarships.id')
        ->selectRaw('scholarships.country, count(*) as total, SUM(scholarship_applications.status = "lolos") as lolos')
        ->groupBy('scholarships.country')
        ->orderByDesc('lolos')
        ->get();

    // ── Per Beasiswa ──
    $byScholarship = ScholarshipApplication::join('scholarships', 'scholarship_applications.scholarship_id', '=', 'scholarships.id')
        ->selectRaw('scholarships.title, scholarships.country, count(*) as total, SUM(scholarship_applications.status = "lolos") as lolos')
        ->groupBy('scholarships.id', 'scholarships.title', 'scholarships.country')
        ->orderByDesc('lolos')
        ->get();

    // ── Per Program Studi ──
    $byProgram = ScholarshipApplication::join('program_studies', 'scholarship_applications.program_study_id', '=', 'program_studies.id')
        ->selectRaw('program_studies.name, count(*) as total, SUM(scholarship_applications.status = "lolos") as lolos')
        ->groupBy('program_studies.name')
        ->orderByDesc('lolos')
        ->get();
@endphp

<div class="exec-dashboard">

    {{-- ═══ KPI CARDS ═══ --}}
    <div class="exec-kpi-grid">
        <div class="exec-kpi-card accent-blue">
            <div class="exec-kpi-icon"><i class="bi bi-collection-fill"></i></div>
            <div>
                <span>Total Applications</span>
                <h2>{{ $saTotal }}</h2>
            </div>
        </div>
        <div class="exec-kpi-card accent-green">
            <div class="exec-kpi-icon"><i class="bi bi-trophy-fill"></i></div>
            <div>
                <span>Total Accepted</span>
                <h2>{{ $saLolos }}</h2>
            </div>
        </div>
        <div class="exec-kpi-card accent-red">
            <div class="exec-kpi-icon"><i class="bi bi-percent"></i></div>
            <div>
                <span>Success Rate</span>
                <h2>{{ $successRate }}%</h2>
            </div>
        </div>
        <div class="exec-kpi-card accent-purple">
            <div class="exec-kpi-icon"><i class="bi bi-link-45deg"></i></div>
            <div>
                <span>PSP Approved + Accepted</span>
                <h2>{{ $pspAndLolos }}</h2>
                <small>cross-verified</small>
            </div>
        </div>
        <div class="exec-kpi-card accent-amber">
            <div class="exec-kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <span>Pending</span>
                <h2>{{ $saPending }}</h2>
            </div>
        </div>
        <div class="exec-kpi-card accent-gray">
            <div class="exec-kpi-icon"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <span>Rejected</span>
                <h2>{{ $saTidakLolos }}</h2>
            </div>
        </div>
    </div>

    {{-- ═══ SUCCESS RATE BAR ═══ --}}
    <div class="exec-panel">
        <h3><i class="bi bi-bar-chart-line-fill"></i> Overall Success Rate</h3>
        <div class="exec-rate-bar-wrap">
            <div class="exec-rate-bar">
                <div class="exec-rate-fill lolos" style="width: {{ $saTotal > 0 ? round($saLolos/$saTotal*100) : 0 }}%"></div>
                <div class="exec-rate-fill tidak_lolos" style="width: {{ $saTotal > 0 ? round($saTidakLolos/$saTotal*100) : 0 }}%"></div>
                <div class="exec-rate-fill pending" style="width: {{ $saTotal > 0 ? round($saPending/$saTotal*100) : 0 }}%"></div>
            </div>
            <div class="exec-rate-legend">
                <span><span class="dot dot-green"></span> Accepted {{ $saTotal > 0 ? round($saLolos/$saTotal*100) : 0 }}%</span>
                <span><span class="dot dot-red"></span> Rejected {{ $saTotal > 0 ? round($saTidakLolos/$saTotal*100) : 0 }}%</span>
                <span><span class="dot dot-amber"></span> Pending {{ $saTotal > 0 ? round($saPending/$saTotal*100) : 0 }}%</span>
            </div>
        </div>
    </div>

    {{-- ═══ MAIN ANALYTICS GRID ═══ --}}
    <div class="exec-analytics-grid">

        {{-- Per Negara --}}
        <div class="exec-panel">
            <h3><i class="bi bi-globe"></i> Analysis by Destination Country</h3>
            @if($byCountry->isEmpty())
                <p class="exec-empty">No data available</p>
            @else
                <div class="exec-table-wrap">
                    <table class="exec-table">
                        <thead>
                            <tr><th>Country</th><th>Total</th><th>Accepted</th><th>Success Rate</th><th>Bar</th></tr>
                        </thead>
                        <tbody>
                            @foreach($byCountry as $row)
                            @php $rate = $row->total > 0 ? round($row->lolos/$row->total*100) : 0; @endphp
                            <tr>
                                <td><strong>{{ $row->country ?: '—' }}</strong></td>
                                <td>{{ $row->total }}</td>
                                <td><span class="exec-badge green">{{ $row->lolos }}</span></td>
                                <td>{{ $rate }}%</td>
                                <td>
                                    <div class="mini-bar"><div class="mini-fill" style="width:{{ $rate }}%"></div></div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Per Program Studi --}}
        <div class="exec-panel">
            <h3><i class="bi bi-book-fill"></i> Analysis by Study Program</h3>
            @if($byProgram->isEmpty())
                <p class="exec-empty">No data available</p>
            @else
                <div class="exec-table-wrap">
                    <table class="exec-table">
                        <thead>
                            <tr><th>Program</th><th>Total</th><th>Accepted</th><th>Rate</th><th>Bar</th></tr>
                        </thead>
                        <tbody>
                            @foreach($byProgram as $row)
                            @php $rate = $row->total > 0 ? round($row->lolos/$row->total*100) : 0; @endphp
                            <tr>
                                <td><strong>{{ $row->name }}</strong></td>
                                <td>{{ $row->total }}</td>
                                <td><span class="exec-badge green">{{ $row->lolos }}</span></td>
                                <td>{{ $rate }}%</td>
                                <td>
                                    <div class="mini-bar"><div class="mini-fill" style="width:{{ $rate }}%"></div></div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Per Beasiswa (full width) --}}
        <div class="exec-panel exec-panel-full">
            <h3><i class="bi bi-mortarboard-fill"></i> Analysis by Scholarship</h3>
            @if($byScholarship->isEmpty())
                <p class="exec-empty">No data available. Add scholarship application data through the mentee menu.</p>
            @else
                <div class="exec-table-wrap">
                    <table class="exec-table">
                        <thead>
                            <tr><th>Scholarship</th><th>Country</th><th>Total Applicants</th><th>Accepted</th><th>Rejected</th><th>Success Rate</th><th>Bar</th></tr>
                        </thead>
                        <tbody>
                            @foreach($byScholarship as $row)
                            @php
                                $rate = $row->total > 0 ? round($row->lolos/$row->total*100) : 0;
                                $tl   = $row->total - $row->lolos;
                            @endphp
                            <tr>
                                <td><strong>{{ $row->title }}</strong></td>
                                <td>{{ $row->country ?: '—' }}</td>
                                <td>{{ $row->total }}</td>
                                <td><span class="exec-badge green">{{ $row->lolos }}</span></td>
                                <td><span class="exec-badge red">{{ $tl }}</span></td>
                                <td><strong>{{ $rate }}%</strong></td>
                                <td style="min-width:100px">
                                    <div class="mini-bar"><div class="mini-fill" style="width:{{ $rate }}%"></div></div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

<style>
.exec-dashboard { padding: 1rem 0; }

/* KPI Grid */
.exec-kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
@media(max-width:900px){ .exec-kpi-grid { grid-template-columns: repeat(2,1fr); } }

.exec-kpi-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    border-left: 5px solid #e2e8f0;
}
.exec-kpi-card.accent-blue   { border-left-color: #3b82f6; }
.exec-kpi-card.accent-green  { border-left-color: #10b981; }
.exec-kpi-card.accent-red    { border-left-color: #ef4444; }
.exec-kpi-card.accent-purple { border-left-color: #8b5cf6; }
.exec-kpi-card.accent-amber  { border-left-color: #f59e0b; }
.exec-kpi-card.accent-gray   { border-left-color: #94a3b8; }

.exec-kpi-icon { font-size: 1.75rem; flex-shrink: 0; opacity: .7; }
.exec-kpi-card span { font-size: .78rem; color: #888; display: block; }
.exec-kpi-card h2  { font-size: 2rem; font-weight: 700; color: #1e293b; margin: 0; line-height: 1; }
.exec-kpi-card small { font-size: .72rem; color: #94a3b8; }

/* Panels */
.exec-panel {
    background: #fff;
    border-radius: 14px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    margin-bottom: 1.5rem;
}
.exec-panel h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}

/* Rate bar */
.exec-rate-bar {
    height: 28px;
    border-radius: 14px;
    background: #f1f5f9;
    overflow: hidden;
    display: flex;
}
.exec-rate-fill { height: 100%; transition: width .6s ease; }
.exec-rate-fill.lolos       { background: #10b981; }
.exec-rate-fill.tidak_lolos { background: #ef4444; }
.exec-rate-fill.pending      { background: #f59e0b; }

.exec-rate-legend {
    display: flex; gap: 1.5rem; margin-top: .75rem; font-size: .82rem; color: #475569; flex-wrap: wrap;
}
.dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: .3rem; }
.dot-green { background: #10b981; }
.dot-red   { background: #ef4444; }
.dot-amber { background: #f59e0b; }

/* Analytics Grid */
.exec-analytics-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.exec-panel-full { grid-column: span 2; }
@media(max-width:768px){ .exec-analytics-grid { grid-template-columns: 1fr; } .exec-panel-full { grid-column: span 1; } }

/* Table */
.exec-table-wrap { overflow-x: auto; }
.exec-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
.exec-table thead tr { background: #f8fafc; }
.exec-table th { padding: .6rem .75rem; text-align: left; font-size: .78rem; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
.exec-table td { padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
.exec-table tbody tr:hover { background: #f8fafc; }

.exec-badge {
    display: inline-block;
    padding: .15rem .6rem;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 600;
}
.exec-badge.green { background: #d1fae5; color: #065f46; }
.exec-badge.red   { background: #fee2e2; color: #991b1b; }

.mini-bar { height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; min-width: 80px; }
.mini-fill { height: 100%; background: linear-gradient(90deg, #10b981, #34d399); border-radius: 4px; }

.exec-empty { color: #94a3b8; font-size: .9rem; text-align: center; padding: 2rem; }
</style>

</x-filament-panels::page>
