<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ========================= GLOBAL ========================= */
.feature-section {
    background: #f4f6f9;
    padding: 60px 0;
    font-family: 'Inter', sans-serif;
}
.feature-container {
    display: flex;
    gap: 28px;
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 32px;
    align-items: flex-start;
}

/* ========================= SIDEBAR ========================= */
.sidebar {
    width: 270px;
    flex-shrink: 0;
}
.filter-panel {
    position: sticky;
    top: 80px;
    background: #fff;
    padding: 24px;
    border-radius: 18px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f0f0f0;
}
.filter-header h4 {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.filter-header h4::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 18px;
    background: linear-gradient(#8b0000, #c0392b);
    border-radius: 4px;
}
.clear-btn {
    font-size: 12px;
    color: #8b0000;
    background: rgba(139,0,0,0.07);
    border: none;
    border-radius: 20px;
    padding: 4px 10px;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.2s;
}
.clear-btn:hover { background: rgba(139,0,0,0.14); }

/* chips */
.filter-selected {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
    min-height: 0;
}
.filter-chip {
    background: rgba(139,0,0,0.08);
    color: #8b0000;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 11px;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.2s;
}
.filter-chip:hover { background: rgba(139,0,0,0.16); }

/* filter group */
.filter-group { margin-bottom: 22px; }
.filter-group h5 {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #999;
    margin-bottom: 10px;
}
.filter-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.scroll {
    max-height: 190px;
    overflow-y: auto;
    padding-right: 4px;
}
.scroll::-webkit-scrollbar { width: 4px; }
.scroll::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

/* checkbox */
.checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 8px;
    transition: background 0.15s;
}
.checkbox:hover { background: #fdf5f5; }
.checkbox input { display: none; }
.checkmark {
    width: 16px;
    height: 16px;
    border-radius: 5px;
    border: 1.5px solid #ddd;
    flex-shrink: 0;
    transition: all 0.2s;
    position: relative;
}
.checkbox input:checked + .checkmark {
    background: #8b0000;
    border-color: #8b0000;
}
.checkbox input:checked + .checkmark::after {
    content: '';
    position: absolute;
    left: 4px; top: 1px;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-left: none; border-top: none;
    transform: rotate(45deg);
}
.cb-content {
    display: flex;
    justify-content: space-between;
    width: 100%;
    font-size: 13px;
    color: #333;
}
.cb-count {
    font-size: 11px;
    color: #000000;
    font-weight: 600;
    /* background: #f4f4f4; */
    padding: 1px 7px;
    border-radius: 20px;
}

/* ========================= MAIN ========================= */
.feature-main { flex: 1; min-width: 0; }

/* topbar */
.feature-topbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: #f4f6f9;
    padding: 12px 0 16px;
    display: flex;
    gap: 12px;
    align-items: center;
    margin-bottom: 24px;
}
.feature-search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    background: #fff;
    padding: 11px 16px;
    border-radius: 12px;
    border: 1.5px solid #e8eaf0;
    transition: all 0.2s;
}
.feature-search-box:focus-within {
    border-color: #8b0000;
    box-shadow: 0 0 0 3px rgba(139,0,0,0.08);
}
.feature-search-box svg { color: #aaa; flex-shrink: 0; }
.feature-search-box input {
    border: none; outline: none;
    width: 100%; font-size: 14px;
    background: transparent; color: #333;
}
.feature-search-box input::placeholder { color: #bbb; }

.deadline-selects {
    display: flex;
    gap: 8px;
}
.deadline-selects select {
    background: #fff;
    border: 1.5px solid #e8eaf0;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    color: #444;
    cursor: pointer;
    outline: none;
    transition: border 0.2s;
    appearance: none;
    -webkit-appearance: none;
    padding-right: 30px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23aaa' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
}
.deadline-selects select:focus { border-color: #8b0000; }

/* result count */
.result-count {
    font-size: 13px;
    color: #999;
    margin-bottom: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.result-count strong { color: #333; }
.scroll-hint {
    font-size: 12px;
    color: #bbb;
    display: flex;
    align-items: center;
    gap: 4px;
    animation: bounceY 1.6s ease-in-out infinite;
}
@keyframes bounceY {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(4px); }
}

/* ========================= GRID WRAPPER ========================= */
.scholar-grid-wrapper {
    position: relative;
}
/* fade-out at bottom */
.scholar-grid-wrapper::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 80px;
    background: linear-gradient(transparent, #f4f6f9);
    pointer-events: none;
    border-radius: 0 0 18px 18px;
    z-index: 2;
    transition: opacity 0.3s;
}
.scholar-grid-wrapper.at-bottom::after { opacity: 0; }

/* ========================= GRID ========================= */
.scholar-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    /* 2 rows × ~240px card + gap = ~500px max visible */
    max-height: 520px;
    overflow-y: auto;
    padding-right: 6px;
    padding-bottom: 30px;
    scroll-behavior: smooth;
    scroll-snap-type: y proximity;
}
/* custom scrollbar */
.scholar-grid::-webkit-scrollbar { width: 5px; }
.scholar-grid::-webkit-scrollbar-track { background: transparent; }
.scholar-grid::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}
.scholar-grid::-webkit-scrollbar-thumb:hover { background: #bbb; }
/* snap each card row */
.scholar-card { scroll-snap-align: start; }

/* ========================= CARD ========================= */
.scholar-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #e8eaf0;
    padding: 24px;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.scholar-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #8b0000, #c0392b);
    border-radius: 4px 0 0 4px;
}
.scholar-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.10);
    border-color: #d0d5dd;
}
.scholar-card.is-selected {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
}
.scholar-card.is-selected::before {
    background: linear-gradient(180deg, #16a34a, #22c55e);
}

.card-scholarship-name {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
    line-height: 1.4;
}
.card-program-name {
    font-size: 13px;
    color: #777;
    font-weight: 500;
    margin-bottom: 14px;
}
.card-meta {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.badge {
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.2px;
}
.badge-country { background: #1a1a2e; color: #fff; }
.badge-funding  { background: #8b0000; color: #fff; }
.badge-competency { background: #f0f4ff; color: #3b5bdb; }

.card-dates {
    display: flex;
    gap: 28px;
    margin-bottom: 16px;
}
.card-dates .date-item small {
    font-size: 11px;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: block;
    margin-bottom: 2px;
}
.card-dates .date-item p {
    margin: 0;
    font-size: 13px;
    font-weight: 600;
    color: #333;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #f3f3f3;
}
.status-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    letter-spacing: 0.5px;
}
.status-open   { background: #dcfce7; color: #16a34a; }
.status-closed { background: #fee2e2; color: #dc2626; }

.card-actions { display: flex; gap: 8px; }
.card-link-btn {
    color: #8b0000;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid #8b0000;
    border-radius: 999px;
    padding: 6px 14px;
    transition: all 0.2s;
}
.card-link-btn:hover { background: #8b0000; color: #fff; }

.card-pilih-btn {
    background: #8b0000;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    border: none;
    border-radius: 999px;
    padding: 6px 16px;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.card-pilih-btn:hover { background: #a80000; transform: scale(1.03); }
.card-pilih-btn.selected {
    background: #22c55e;
    color: #fff;
}
.card-pilih-btn.selected:hover { background: #16a34a; }

/* cta bar */
.cta-bar {
    margin-top: 32px;
    background: linear-gradient(135deg, #8b0000 0%, #c0392b 100%);
    border-radius: 18px;
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    gap: 20px;
}
.cta-bar h3 { font-size: 18px; font-weight: 700; margin: 0 0 6px; }
.cta-bar p  { font-size: 14px; opacity: 0.85; margin: 0; }
.btn-cta {
    background: #fff;
    color: #8b0000;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 24px;
    border-radius: 999px;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.btn-cta:hover { background: #ffe0e0; transform: scale(1.03); }

/* floating button */
.floating-next {
    position: fixed;
    bottom: 28px; right: 28px;
    background: #8b0000;
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 12px 22px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(139,0,0,0.35);
    transition: all 0.2s;
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 6px;
}
.floating-next:hover { background: #a80000; transform: translateY(-2px); }

/* no results */
.no-results {
    grid-column: 1/-1;
    text-align: center;
    padding: 60px 20px;
    color: #aaa;
    font-size: 14px;
}

/* ========================= RESPONSIVE ========================= */
@media(max-width: 960px){
    .feature-container { flex-direction: column; padding: 0 16px; }
    .sidebar { width: 100%; }
    .filter-panel { position: static; }
    .scholar-grid { grid-template-columns: 1fr; }
    .cta-bar { flex-direction: column; text-align: center; }
    .floating-next { bottom: 16px; right: 16px; }
    .deadline-selects { flex-direction: column; }
    .feature-topbar { flex-wrap: wrap; }
}
</style>

<section class="feature-section">
<div class="feature-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="filter-panel">
            <div class="filter-header">
                <h4>Filter</h4>
                <button class="clear-btn" onclick="clearFilters()">Clear All</button>
            </div>

            <!-- Active chips -->
            <div class="filter-selected" id="selectedChips"></div>

            <!-- Competency -->
            <div class="filter-group">
                <h5>Competency</h5>
                <div class="filter-options scroll">
                    @php
                    $pspCompetencies = \App\Models\Competency::pluck('name')->toArray();
                    @endphp
                    @foreach($pspCompetencies as $comp)
                    @php $cnt = $programStudies->filter(fn($p)=>strtolower($p->competency)===strtolower($comp))->count(); @endphp
                    @if($cnt > 0)
                    <label class="checkbox">
                        <input type="checkbox" class="filter-check" data-type="competency" value="{{ $comp }}" onchange="applyFilters()">
                        <span class="checkmark"></span>
                        <div class="cb-content">
                            <span>{{ $comp }}</span>
                            <span class="cb-count">{{ $cnt }}</span>
                        </div>
                    </label>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Country -->
            <div class="filter-group">
                <h5>Country</h5>
                <div class="filter-options scroll">
                    @foreach($programStudies->pluck('country')->filter()->unique()->values() as $country)
                    <label class="checkbox">
                        <input type="checkbox" class="filter-check" data-type="country" value="{{ $country }}" onchange="applyFilters()">
                        <span class="checkmark"></span>
                        <div class="cb-content">
                            <span>{{ $country }}</span>
                            <span class="cb-count">{{ $programStudies->where('country', $country)->count() }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- MAIN -->
    <div class="feature-main">

        <!-- STICKY TOPBAR: Search + Filter -->
        <div class="feature-topbar" style="flex-wrap: wrap;">
            <div class="feature-search-box" style="flex: 1 1 100%;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" id="featureSearch" placeholder="Search scholarship or program name..." oninput="applyFilters()">
            </div>
            <div style="flex: 1 1 100%; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; margin-top: -10px; margin-bottom: 5px;">
                <div style="font-size: 13px; color: #475569; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-info-circle-fill" style="color: #3b82f6; font-size: 15px;"></i>
                    <span>Program Study not found?</span>
                </div>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; justify-content: flex-end;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#psr-modal" style="font-size: 12.5px; color: #fff; background: #8b0000; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(139,0,0,0.2);">
                        <i class="bi bi-plus-circle"></i> Suggest a new one
                    </a>
                    <a href="#" onclick="mysuggOpen()" style="font-size: 12.5px; color: #475569; background: #fff; border: 1px solid #cbd5e1; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <i class="bi bi-clock-history"></i> My Suggestions
                    </a>
                </div>
            </div>
            <div class="deadline-selects">
                <select id="deadlineSort" onchange="applyFilters()">
                    <option value="upcoming">⬆ Nearest Deadline</option>
                    <option value="latest">⬇ Furthest Deadline</option>
                </select>
                <select id="deadlineFilter" onchange="applyFilters()">
                    <option value="all">All Status</option>
                    <option value="upcomingOnly">Upcoming Only</option>
                    <option value="latestOnly">Past Deadline</option>
                </select>
            </div>
        </div>

        <!-- Result count -->
        <div class="result-count" id="resultCount">
            <span id="resultText"></span>
            <span class="scroll-hint" id="scrollHint">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Scroll for more
            </span>
        </div>

        <!-- GRID WRAPPER (fade-out effect) -->
        <div class="scholar-grid-wrapper" id="scholarGridWrapper">
        <div class="scholar-grid" id="scholarGrid">
            @forelse($programStudies as $program)
            @php
                $scholarship = $program->scholarships->first();
                $funding     = $scholarship ? $scholarship->funding_type : ($program->scholarship ?? '');
                $title       = $program->scholarship ?: ($scholarship ? $scholarship->title : $program->name);
                $isOpen      = !$program->deadline || \Carbon\Carbon::now()->isBefore($program->deadline);
            @endphp
            <div class="scholar-card"
                data-id="{{ $program->id }}"
                data-competency="{{ strtolower($program->competency) }}"
                data-country="{{ $program->country }}"
                data-funding="{{ $funding }}"
                data-title="{{ strtolower($title . ' ' . $program->name) }}"
                data-deadline="{{ $program->deadline ? $program->deadline->format('Y-m-d') : '9999-12-31' }}">

                <div class="card-scholarship-name">{{ $title }}</div>
                <div class="card-program-name">{{ $program->name }}</div>

                <div class="card-meta">
                    @if($program->country)
                        <span class="badge badge-country">{{ $program->country }}</span>
                    @endif
                    @if($program->competency)
                        <span class="badge badge-competency">{{ $program->competency }}</span>
                    @endif
                </div>

                <div class="card-dates">
                    <div class="date-item">
                        <small>Start</small>
                        <p>{{ $program->open_date ? $program->open_date->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="date-item">
                        <small>Deadline</small>
                        <p>{{ $program->deadline ? $program->deadline->format('d M Y') : '-' }}</p>
                    </div>
                </div>

                <div class="card-footer">
                    <span class="status-badge {{ $isOpen ? 'status-open' : 'status-closed' }}">
                        {{ $isOpen ? '● OPEN' : '✕ CLOSED' }}
                    </span>
                    <div class="card-actions">
                        <a href="{{ route('psp.program.show', $program->id) }}" class="card-link-btn">Detail →</a>
                        <button
                            class="card-pilih-btn"
                            data-id="{{ $program->id }}"
                            data-scholarship-id="{{ $scholarship ? $scholarship->id : '' }}"
                            data-title="{{ addslashes($title) }}"
                            data-country="{{ addslashes($program->country ?? '') }}"
                            data-funding="{{ addslashes($funding) }}"
                            data-program="{{ addslashes($program->name) }}"
                            onclick="pilihBeasiswa(this)"
                        >+ Choose</button>
                    </div>
                </div>
            </div>
            @empty
                <div class="no-results">No study programs available yet.</div>
            @endforelse
        </div><!-- end .scholar-grid -->
        </div><!-- end .scholar-grid-wrapper -->

        <!-- CTA BAR -->
        <div class="cta-bar" id="cta-bar">
            <div>
                <h3>Interested in a scholarship?</h3>
                <p>Select a scholarship above, then proceed to your research topic.</p>
            </div>
            <a href="{{ route('psp') }}#submit-study-plan" class="btn-cta">Continue →</a>
        </div>

    </div>
</div>
</section>

<!-- Floating nav button -->
<button class="floating-next" onclick="goToNextSection()">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M12 5v14M5 12l7 7 7-7"/>
    </svg>
    Next
</button>

<script>
/* ---- NAVIGATION ---- */
function goToNextSection() {
    document.getElementById('cta-bar')?.scrollIntoView({ behavior: 'smooth' });
}

/* ---- FILTERS ---- */
function applyFilters() {
    const keyword = document.getElementById('featureSearch').value.toLowerCase().trim();
    const sort    = document.getElementById('deadlineSort').value;
    const filter  = document.getElementById('deadlineFilter').value;
    const cards   = Array.from(document.querySelectorAll('.scholar-card'));
    const checks  = document.querySelectorAll('.filter-check:checked');

    const sel = { competency: [], country: [] };
    checks.forEach(c => {
        if (sel[c.dataset.type]) sel[c.dataset.type].push(c.value.toLowerCase());
    });

    updateChips(sel);

    const now = new Date();

    let visible = cards.filter(card => {
        const titleMatch   = card.dataset.title.includes(keyword);
        const compMatch    = !sel.competency.length || sel.competency.includes(card.dataset.competency);
        const countryMatch = !sel.country.length    || sel.country.map(v=>v.toLowerCase()).includes(card.dataset.country.toLowerCase());

        let deadlineMatch = true;
        const dl = new Date(card.dataset.deadline);
        if (filter === 'upcomingOnly') deadlineMatch = dl >= now;
        if (filter === 'latestOnly')   deadlineMatch = dl < now;

        return titleMatch && compMatch && countryMatch && deadlineMatch;
    });

    // Sort
    visible.sort((a, b) => {
        const cmp = a.dataset.deadline.localeCompare(b.dataset.deadline);
        return sort === 'latest' ? -cmp : cmp;
    });

    // Render
    const grid = document.getElementById('scholarGrid');
    cards.forEach(c => c.style.display = 'none');
    visible.forEach(c => { c.style.display = 'flex'; grid.appendChild(c); });

    // Result count + scroll hint
    const rt = document.getElementById('resultText');
    if (rt) rt.innerHTML = `Showing <strong>${visible.length}</strong> of <strong>${cards.length}</strong> programs`;
    const sh = document.getElementById('scrollHint');
    if (sh) sh.style.display = visible.length > 4 ? 'flex' : 'none';
    updateScrollFade();
}

function updateChips(sel) {
    const container = document.getElementById('selectedChips');
    if (!container) return;
    container.innerHTML = '';
    Object.entries(sel).forEach(([type, vals]) => {
        vals.forEach(v => {
            const chip = document.createElement('span');
            chip.className = 'filter-chip';
            chip.innerText = v + ' ✕';
            chip.onclick = () => {
                const el = document.querySelector(`.filter-check[data-type="${type}"][value="${v}"]`)
                        || document.querySelector(`.filter-check[data-type="${type}"]`);
                if (el) el.checked = false;
                applyFilters();
            };
            container.appendChild(chip);
        });
    });
}

function clearFilters() {
    document.querySelectorAll('.filter-check').forEach(c => c.checked = false);
    document.getElementById('featureSearch').value = '';
    document.getElementById('deadlineFilter').value = 'all';
    applyFilters();
}

/* ---- PILIH BEASISWA ---- */
function pilihBeasiswa(btn) {
    const id           = parseInt(btn.dataset.id);
    const scholarshipId = parseInt(btn.dataset.scholarshipId) || 0;
    const KEY          = 'psp_selected_scholarships';
    let   list         = JSON.parse(localStorage.getItem(KEY) || '[]');
    const exists       = list.findIndex(s => s.id === id);

    if (exists >= 0) {
        // Sudah dipilih → hapus (toggle off)
        list.splice(exists, 1);
    } else {
        // Belum dipilih → tambahkan (multi-select)
        list.push({
            id,
            scholarshipId,
            title:   btn.dataset.title,
            country: btn.dataset.country,
            funding: btn.dataset.funding,
            program: btn.dataset.program
        });
    }

    localStorage.setItem(KEY, JSON.stringify(list));
    updatePilihButtons();
    window.dispatchEvent(new Event('pspSelectionChanged'));
}

function updatePilihButtons() {
    const KEY  = 'psp_selected_scholarships';
    const list = JSON.parse(localStorage.getItem(KEY) || '[]');
    const ids  = list.map(s => s.id);

    document.querySelectorAll('.scholar-card').forEach(card => {
        const btn    = card.querySelector('.card-pilih-btn');
        const cardId = parseInt(card.dataset.id);
        const isSel  = ids.includes(cardId);

        if (btn) {
            btn.textContent = isSel ? '✓ Selected' : '+ Choose';
            btn.classList.toggle('selected', isSel);
        }
        card.classList.toggle('is-selected', isSel);
    });
}

/* ---- AUTO SELECT FROM DETAIL PAGE ---- */
(function autoSelectFromDetail() {
    const fromId = parseInt(localStorage.getItem('psp_from_detail') || '0');
    if (!fromId) return;

    document.querySelectorAll('.scholar-card').forEach(card => {
        const btn          = card.querySelector('.card-pilih-btn');
        const scholarshipId = parseInt(btn?.dataset.scholarshipId || '0');
        if (!btn || scholarshipId !== fromId) return;

        const KEY  = 'psp_selected_scholarships';
        const list = [{
            id:           parseInt(btn.dataset.id),
            scholarshipId: fromId,
            title:         btn.dataset.title,
            country:       btn.dataset.country,
            funding:       btn.dataset.funding,
            program:       btn.dataset.program
        }];
        localStorage.setItem(KEY, JSON.stringify(list));
    });

    localStorage.removeItem('psp_from_detail');
    window.dispatchEvent(new Event('pspSelectionChanged'));
})();

/* ---- INIT ---- */
applyFilters();
updatePilihButtons();

/* ---- SCROLL FADE DETECTION ---- */
function updateScrollFade() {
    const grid    = document.getElementById('scholarGrid');
    const wrapper = document.getElementById('scholarGridWrapper');
    if (!grid || !wrapper) return;
    const atBottom = grid.scrollTop + grid.clientHeight >= grid.scrollHeight - 10;
    wrapper.classList.toggle('at-bottom', atBottom);
    const sh = document.getElementById('scrollHint');
    if (sh) sh.style.display = atBottom ? 'none' : 'flex';
}
document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('scholarGrid');
    if (grid) grid.addEventListener('scroll', updateScrollFade, { passive: true });
});
</script>