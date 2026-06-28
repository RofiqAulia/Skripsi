<style>
/* ═══════════════════════════════════════
   FINANCIAL PLAN — Redesigned Styles
   ═══════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
    --fp-primary: #c0392b;
    --fp-primary-light: #e74c3c;
    --fp-primary-grad: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    --fp-dark: #0f172a;
    --fp-slate: #1e293b;
    --fp-muted: #64748b;
    --fp-border: #e2e8f0;
    --fp-surface: #f8fafc;
    --fp-white: #ffffff;
}

.fp-section {
    padding: 0 0 4rem;
    min-height: 100vh;
    background: #f0f2f8;
    font-family: 'Inter', sans-serif;
}

/* ──── HERO BANNER ──── */
.fp-hero {
    position: relative;
    background: var(--fp-primary-grad);
    overflow: hidden;
    padding: 7rem 0 4rem;
    margin-bottom: 0;
}

.fp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(0,0,0,0.12) 0%, transparent 60%);
    pointer-events: none;
}

.fp-hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.15;
    pointer-events: none;
}
.fp-hero-orb-1 {
    width: 400px; height: 400px;
    background: #fff;
    top: -100px; right: -100px;
}
.fp-hero-orb-2 {
    width: 300px; height: 300px;
    background: #000;
    bottom: -80px; left: 20%;
}

.fp-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 2rem;
    flex-wrap: wrap;
}

.fp-hero-text .fp-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.35rem 0.9rem;
    border-radius: 30px;
    margin-bottom: 1rem;
}

.fp-hero-text h1 {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 0.75rem;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.fp-hero-text p {
    color: rgba(255,255,255,0.75);
    font-size: 1rem;
    margin: 0;
    max-width: 480px;
}

.fp-hero-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Status Badge */
.fp-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.82rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    border: 1.5px solid transparent;
}
.fp-badge.status-draft          { background: rgba(255,255,255,0.18); color: #fff; border-color: rgba(255,255,255,0.3); }
.fp-badge.status-submitted      { background: #dbeafe; color: #1e40af; }
.fp-badge.status-under_review   { background: #fef3c7; color: #92400e; }
.fp-badge.status-revision_needed { background: #fee2e2; color: #991b1b; }
.fp-badge.status-approved       { background: #d1fae5; color: #065f46; }

.fp-badge-sm {
    display: inline-flex; align-items: center;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.fp-badge-sm.status-pending  { background: #fef3c7; color: #92400e; }
.fp-badge-sm.status-approved { background: #d1fae5; color: #065f46; }
.fp-badge-sm.status-rejected { background: #fee2e2; color: #991b1b; }

/* Hero Stats Row */
.fp-hero-stats {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.fp-hero-stat {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}
.fp-hero-stat .stat-val {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.fp-hero-stat .stat-lbl {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.65);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* ──── JOURNEY STRIP ──── */
.fp-journey-strip {
    background: var(--fp-white);
    border-bottom: 1px solid var(--fp-border);
    box-shadow: 0 4px 24px rgba(0,0,0,0.05);
}
.fp-journey {
    max-width: 1140px;
    margin: 0 auto;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    overflow-x: auto;
}
.journey-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    z-index: 2;
    min-width: 120px;
}
.journey-step .j-icon {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e2e8f0;
    transition: all 0.3s;
}
.journey-step span {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-align: center;
}
.journey-step.active .j-icon {
    background: var(--fp-primary);
    color: #fff;
    box-shadow: 0 0 0 4px rgba(192,57,43,0.2);
}
.journey-step.active span { color: var(--fp-primary); }
.journey-step.completed .j-icon {
    background: #10b981;
    color: #fff;
    box-shadow: 0 0 0 2px #a7f3d0;
}
.journey-step.completed span { color: #10b981; }
.journey-line {
    flex: 1;
    height: 3px;
    background: #e2e8f0;
    margin: -22px 6px 0;
    position: relative;
    z-index: 1;
    border-radius: 2px;
}
.journey-line.completed { background: #10b981; }

/* ──── MAIN CONTAINER ──── */
.fp-container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ──── ALERTS ──── */
.fp-alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}
.fp-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
.fp-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* ──── LAYOUT GRID ──── */
.fp-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
    padding-top: 2rem;
}
@media(max-width:992px) { .fp-grid { grid-template-columns: 1fr; } }

/* ──── CARDS ──── */
.fp-card {
    background: var(--fp-white);
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
    border: 1px solid var(--fp-border);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.fp-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--fp-border);
    background: #fafbff;
}
.fp-card-header h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: var(--fp-slate);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.fp-card-header h5 i { color: var(--fp-primary); }
.fp-card-body { padding: 1.25rem 1.5rem; }

/* ──── PROFILE INFO (Read-only chips) ──── */
.fp-profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}
@media(max-width:576px) { .fp-profile-grid { grid-template-columns: 1fr; } }
.fp-info-chip {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    padding: 0.75rem 1rem;
    background: var(--fp-surface);
    border: 1px solid var(--fp-border);
    border-radius: 10px;
}
.fp-info-chip label {
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--fp-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.fp-info-chip span {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--fp-slate);
}

/* ──── STUDY DETAILS FORM ──── */
.fp-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
@media(max-width:576px) { .fp-form-grid { grid-template-columns: 1fr; } }
.fp-form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.fp-form-group label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--fp-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.fp-input, .fp-select, .fp-input-sm {
    width: 100%;
    padding: 0.6rem 0.9rem;
    border: 1.5px solid var(--fp-border);
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--fp-slate);
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
    font-family: 'Inter', sans-serif;
}
.fp-input:focus, .fp-select:focus, .fp-input-sm:focus {
    outline: none;
    background: var(--fp-white);
    border-color: var(--fp-primary);
    box-shadow: 0 0 0 3px rgba(192,57,43,0.1);
}
.fp-input-sm { padding: 0.35rem 0.6rem; font-size: 0.82rem; }

/* Target Scholarship select - special */
.fp-scholarship-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--fp-primary);
    background: #fff;
    font-weight: 600;
    color: var(--fp-slate);
    border-radius: 10px;
    font-size: 0.9rem;
    width: 100%;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.fp-scholarship-select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(192,57,43,0.12);
}

/* ──── CATEGORY TABS ──── */
.fp-cat-tabs {
    display: flex;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--fp-border);
    background: #fafbff;
    overflow-x: auto;
    flex-wrap: nowrap;
}
.fp-cat-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--fp-muted);
    background: var(--fp-white);
    border: 1.5px solid var(--fp-border);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    user-select: none;
}
.fp-cat-tab:hover { border-color: var(--fp-primary); color: var(--fp-primary); }
.fp-cat-tab.active {
    background: var(--fp-primary);
    color: #fff;
    border-color: var(--fp-primary);
    box-shadow: 0 3px 10px rgba(192,57,43,0.25);
}
.fp-cat-tab .cat-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px; height: 18px;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    font-size: 0.68rem;
    font-weight: 700;
}
.fp-cat-tab:not(.active) .cat-count { background: var(--fp-border); color: var(--fp-muted); }

.fp-cat-panel { display: none; }
.fp-cat-panel.active { display: block; }

/* ──── CATEGORY TABLE ──── */
.fp-table-wrap { overflow-x: auto; }
.fp-table { width: 100%; min-width: 580px; border-collapse: collapse; }
.fp-table th {
    background: var(--fp-surface);
    padding: 0.65rem 1rem;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--fp-muted);
    text-align: left;
    border-bottom: 2px solid var(--fp-border);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.fp-table td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    font-size: 0.88rem;
}
.fp-table tr:last-child td { border-bottom: none; }
.fp-table tr:hover td { background: #fafbff; }
.fp-table td:first-child { font-weight: 600; color: var(--fp-slate); }
.gap-amount { font-weight: 700; font-family: 'Inter', monospace; font-size: 0.9rem; }

/* ──── CATEGORY TOTAL FOOTER ──── */
.fp-cat-footer {
    display: flex;
    justify-content: flex-end;
    gap: 2rem;
    padding: 0.75rem 1.5rem;
    background: #f8fafc;
    border-top: 2px solid var(--fp-border);
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--fp-muted);
}
.fp-cat-footer span strong {
    display: block;
    font-size: 1rem;
    color: var(--fp-slate);
    font-family: monospace;
}

/* ──── DOCUMENT UPLOAD ──── */
.fp-upload-area {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2.5rem 2rem;
    text-align: center;
    background: var(--fp-surface);
    transition: all 0.2s;
}
.fp-upload-area:hover { border-color: var(--fp-primary); background: #fff5f5; }
.fp-doc-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid var(--fp-border);
    border-radius: 10px;
    margin-bottom: 0.75rem;
    background: var(--fp-white);
}
.fp-doc-item:last-child { margin-bottom: 0; }
.doc-icon {
    width: 40px; height: 40px;
    background: #fff5f5; color: var(--fp-primary);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; margin-right: 1rem; flex-shrink: 0;
}
.doc-info { flex: 1; min-width: 0; }
.doc-info h6 { margin: 0 0 0.2rem; font-size: 0.95rem; font-weight: 600; color: var(--fp-slate); }
.doc-info span { font-size: 0.8rem; color: var(--fp-muted); }
.doc-status { margin: 0 1rem; }
.doc-actions { display: flex; gap: 0.5rem; }
.btn-icon {
    width: 32px; height: 32px;
    border-radius: 6px; border: none; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.2s; text-decoration: none;
}
.btn-icon:hover { background: var(--fp-border); }

/* ──── ACTION BUTTONS ──── */
.fp-actions-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: var(--fp-white);
    border-radius: 14px;
    border: 1px solid var(--fp-border);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}
.fp-actions-left { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
.fp-btn-save {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--fp-surface);
    color: var(--fp-muted);
    border: 1.5px solid var(--fp-border);
    padding: 0.55rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.fp-btn-save:hover { background: #f1f5f9; color: var(--fp-slate); border-color: #94a3b8; }

.fp-btn-submit-main {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border: none;
    padding: 0.65rem 1.75rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.92rem;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16,185,129,0.3);
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.fp-btn-submit-main:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,0.35);
}

/* ──── SUMMARY SIDEBAR ──── */
.summary-card { position: sticky; top: 5rem; }
.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
}
.summary-item:last-child { border-bottom: none; }
.summary-item span { color: var(--fp-muted); font-weight: 500; }
.summary-item strong { color: var(--fp-slate); font-family: monospace; font-size: 0.95rem; }
.gap-item { border-top: 2px solid var(--fp-border) !important; margin-top: 0.5rem; padding-top: 0.75rem !important; }
.gap-item strong { font-size: 1.1rem; }

/* ──── UPLOAD REF BUTTON ──── */
.fp-upload-ref-btn {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1px;
    background: #f0f9ff;
    border: 1.5px dashed #38bdf8;
    color: #0284c7;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 0.72rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    line-height: 1.3;
    min-width: 64px;
}
.fp-upload-ref-btn:hover {
    background: #e0f2fe;
    border-color: #0284c7;
    transform: translateY(-1px);
}
.fp-upload-ref-btn i { font-size: 0.95rem; }
.fp-upload-ref-btn small { font-size: 0.62rem; color: #64748b; font-weight: 400; }

.fp-ref-file-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--fp-slate);
    text-decoration: none;
    background: var(--fp-surface);
    border: 1px solid var(--fp-border);
    border-radius: 6px;
    padding: 3px 8px;
    max-width: 120px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    transition: background 0.15s;
}
.fp-ref-file-link:hover { background: var(--fp-border); color: #0f172a; }

/* ──── SUBMIT AREA ──── */
.fp-submit-area {
    padding: 1.25rem 1.5rem;
    background: var(--fp-white);
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    border: 1px solid var(--fp-border);
    margin-bottom: 1.25rem;
}

/* ──── RESPONSIVE ──── */
@media(max-width:768px) {
    .fp-hero { padding: 6rem 0 3rem; }
    .fp-hero-text h1 { font-size: 1.6rem; }
    .fp-hero-right { width: 100%; }
    .fp-cat-tabs { padding: 0.75rem 1rem; }
    .fp-table th, .fp-table td { padding: 0.5rem 0.75rem; }
}
</style>
