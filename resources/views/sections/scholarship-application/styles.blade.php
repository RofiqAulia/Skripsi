<style>
/* ═══════════════════════════════════════
   SCHOLARSHIP APPLICATION — Styles
   ═══════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
    --sa-primary: #c0392b;
    --sa-primary-grad: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
}

.sa-section {
    padding: 0 0 4rem;
    min-height: 100vh;
    background: #f0f2f8;
    font-family: 'Inter', sans-serif;
}

.sa-container { max-width: 960px; padding-top: 2rem; }

/* ──── HERO BANNER ──── */
.sa-hero {
    position: relative;
    background: var(--sa-primary-grad);
    overflow: hidden;
    padding: 7rem 0 3.5rem;
}

.sa-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(0,0,0,0.12) 0%, transparent 60%);
    pointer-events: none;
}

.sa-hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.15;
    pointer-events: none;
}
.sa-hero-orb-1 { width: 380px; height: 380px; background: #fff;    top: -120px; right: -80px; }
.sa-hero-orb-2 { width: 280px; height: 280px; background: #000;    bottom: -80px; left: 25%; }

.sa-hero-inner {
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

.sa-hero-text .sa-hero-eyebrow {
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

.sa-hero-text h1 {
    font-size: clamp(1.7rem, 4vw, 2.5rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 0.6rem;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.sa-hero-text p {
    color: rgba(255,255,255,0.75);
    font-size: 0.98rem;
    margin: 0;
    max-width: 460px;
}

.sa-hero-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1.25rem;
}

/* Stats inside hero */
.sa-hero-stats {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 14px;
    padding: 0.85rem 1.25rem;
}
.sa-hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.1rem;
}
.sa-hero-divider {
    width: 1px;
    height: 32px;
    background: rgba(255,255,255,0.25);
}
.sa-stat-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    font-family: 'Inter', sans-serif;
}
.sa-stat-lbl {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.6);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* Add button — hero variant */
.sa-btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.4rem;
    background: rgba(255,255,255,0.95);
    color: var(--sa-primary);
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-size: 0.9rem;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    backdrop-filter: blur(4px);
}
.sa-btn-add:hover {
    background: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    color: var(--sa-primary);
}
.sa-btn-add--locked {
    background: rgba(255,255,255,0.25);
    color: rgba(255,255,255,0.7);
    cursor: not-allowed;
    box-shadow: none;
}
.sa-btn-add--locked:hover { transform: none; background: rgba(255,255,255,0.25); color: rgba(255,255,255,0.7); }

@media(max-width:768px) {
    .sa-hero { padding: 6rem 0 3rem; }
    .sa-hero-inner { flex-direction: column; align-items: flex-start; }
    .sa-hero-right { align-items: flex-start; width: 100%; }
    .sa-hero-stats { width: 100%; justify-content: space-around; }
}

/* Old header gone - not needed */
.sa-header { display: none; }



/* Alerts */
.sa-alert {
    padding: 0.9rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-weight: 500;
}
.sa-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
.sa-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* Stat Cards */
.sa-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
@media(max-width:768px) { .sa-stats { grid-template-columns: repeat(2,1fr); } }

.sa-stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.sa-stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff; flex-shrink: 0;
}
.bg-blue   { background: linear-gradient(135deg,#3b82f6,#60a5fa); }
.bg-green  { background: linear-gradient(135deg,#10b981,#34d399); }
.bg-amber  { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
.bg-red    { background: linear-gradient(135deg,#ef4444,#f87171); }

.sa-stat-card span { font-size: .78rem; color: #888; display: block; }
.sa-stat-card h3   { font-size: 1.75rem; font-weight: 700; color: #1a1a2e; margin: 0; }

/* Empty State */
.sa-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.sa-empty i   { font-size: 3rem; color: #cbd5e1; }
.sa-empty p   { color: #888; margin: 1rem 0 1.5rem; font-size: 1.05rem; }

/* Application Cards */
.sa-list { display: flex; flex-direction: column; gap: 1.25rem; }

.sa-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 14px rgba(0,0,0,.07);
    overflow: hidden;
    border-left: 5px solid #cbd5e1;
    transition: box-shadow .2s;
}
.sa-card:hover    { box-shadow: 0 4px 24px rgba(0,0,0,.12); }
.sa-card.lolos    { border-left-color: #10b981; }
.sa-card.tidak_lolos { border-left-color: #ef4444; }
.sa-card.pending  { border-left-color: #f59e0b; }

.sa-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1.25rem 1.5rem 0.75rem;
    gap: 1rem;
    flex-wrap: wrap;
}
.sa-card-title h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0.4rem 0 0.5rem;
}
.sa-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    font-size: 0.82rem;
    color: #666;
}
.sa-card-meta span { display: flex; align-items: center; gap: 0.3rem; }

.sa-psp-badge {
    background: #ede9fe;
    color: #7c3aed;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.78rem !important;
}

/* Badges */
.sa-badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
}
.sa-badge.status-lolos       { background:#d1fae5; color:#065f46; }
.sa-badge.status-tidak_lolos { background:#fee2e2; color:#991b1b; }
.sa-badge.status-pending      { background:#fef3c7; color:#92400e; }

.sa-badge-sm {
    display: inline-flex; align-items: center;
    padding: 0.15rem 0.55rem;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 600;
}
.sa-badge-sm.status-lolos       { background:#d1fae5; color:#065f46; }
.sa-badge-sm.status-tidak_lolos { background:#fee2e2; color:#991b1b; }
.sa-badge-sm.status-pending      { background:#fef3c7; color:#92400e; }

/* Card Actions */
.sa-card-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
}
.sa-btn-stage, .sa-btn-expand {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.4rem 0.9rem;
    border-radius: 7px;
    font-size: 0.82rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: opacity .2s;
}
.sa-btn-stage  { background: #ede9fe; color: #6d28d9; }
.sa-btn-expand { background: #e0f2fe; color: #0369a1; }
.sa-btn-del    { background: #fee2e2; color: #991b1b; border: none; border-radius: 7px; padding: 0.4rem 0.7rem; cursor: pointer; font-size: 0.9rem; transition: opacity .2s; }
.sa-btn-stage:hover, .sa-btn-expand:hover, .sa-btn-del:hover { opacity: 0.8; }

/* Current Stage */
.sa-current-stage {
    padding: 0.6rem 1.5rem;
    background: #f8fafc;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-top: 1px solid #f1f5f9;
    font-size: 0.85rem;
}
.sa-stage-label { color: #888; }
.sa-stage-chip  {
    background: #1a1a2e;
    color: #fff;
    padding: 0.2rem 0.75rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
}
.sa-stage-date { color: #aaa; margin-left: auto; }

/* Financial Plan CTA */
.sa-success-cta {
    margin: 1.25rem 1.5rem;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(to right, #ecfdf5, #f0fdf4);
    border-radius: 12px;
    border-left: 4px solid #10b981;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
}
@media(max-width:768px) {
    .sa-success-cta { flex-direction: column; text-align: center; gap: 0.75rem; align-items: stretch; }
}
.sa-success-icon { font-size: 2rem; line-height: 1; }
.sa-success-content { flex: 1; }
.sa-success-content h5 { color: #065f46; font-weight: 700; margin: 0 0 0.35rem 0; font-size: 1.1rem; }
.sa-success-content p { color: #047857; margin: 0; font-size: 0.88rem; line-height: 1.4; }
.sa-btn-continue-fp {
    background: #10b981;
    color: #fff;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    white-space: nowrap;
}
.sa-btn-continue-fp:hover {
    background: #059669;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
}

/* History Timeline */
.sa-history {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #f1f5f9;
    background: #fafbff;
}
.sa-history h6 {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: 0.4rem;
}

.sa-timeline { position: relative; padding-left: 1.5rem; }
.sa-timeline::before {
    content: '';
    position: absolute;
    left: 7px; top: 0; bottom: 0;
    width: 2px; background: #e2e8f0;
}
.sa-timeline-item { position: relative; margin-bottom: 1.1rem; }
.sa-timeline-item.last { margin-bottom: 0; }

.sa-tl-dot {
    position: absolute;
    left: -1.47rem; top: 4px;
    width: 14px; height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e2e8f0;
}
.status-dot-lolos       { background: #10b981; box-shadow: 0 0 0 2px #6ee7b7; }
.status-dot-tidak_lolos { background: #ef4444; box-shadow: 0 0 0 2px #fca5a5; }
.status-dot-pending      { background: #f59e0b; box-shadow: 0 0 0 2px #fcd34d; }

.sa-tl-header { display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; }
.sa-tl-header strong { font-size: 0.88rem; color: #1a1a2e; }
.sa-tl-date { font-size: 0.78rem; color: #aaa; margin-left: auto; }
.sa-tl-notes { font-size: 0.82rem; color: #666; margin-top: 0.3rem; margin-bottom: 0; }

/* Modal */
.sa-modal { border-radius: 16px; border: none; overflow: hidden; }
.sa-modal-header {
    background: linear-gradient(135deg, #1a1a2e, #2d2d44);
    color: #fff;
    border: none;
    padding: 1.25rem 1.5rem;
}
.sa-modal-header h5 { color: #fff; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
.sa-modal-subtitle { font-size: 0.9rem; color: #666; font-weight: 600; margin-bottom: 0.75rem; }
.sa-modal-footer { border-top: 1px solid #f1f5f9; padding: 1rem 1.5rem; }

.sa-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.sa-form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.sa-form-group.full { grid-column: span 2; }
@media(max-width:576px) {
    .sa-form-grid { grid-template-columns: 1fr; }
    .sa-form-group.full { grid-column: span 1; }
}
.sa-form-group label { font-size: 0.85rem; font-weight: 600; color: #374151; }
.req { color: #ef4444; }
.opt { color: #9ca3af; font-weight: 400; }

.sa-input, .sa-select, .sa-textarea {
    width: 100%;
    padding: 0.6rem 0.9rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #1a1a2e;
    transition: border-color .2s;
    background: #fff;
}
.sa-input:focus, .sa-select:focus, .sa-textarea:focus {
    outline: none;
    border-color: #c0392b;
    box-shadow: 0 0 0 3px rgba(192,57,43,.12);
}
.sa-input[readonly] { background: #f9fafb; color: #6b7280; cursor: default; }
.sa-textarea { resize: vertical; }

.sa-btn-cancel {
    padding: 0.55rem 1.25rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    background: #fff;
    color: #666;
    cursor: pointer;
    font-weight: 600;
}
.sa-btn-submit {
    padding: 0.55rem 1.5rem;
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex; align-items: center; gap: 0.4rem;
    transition: opacity .2s;
}
.sa-btn-submit:hover { opacity: .9; }

/* Custom Searchable Dropdown */
.sa-search-dropdown-wrapper {
    position: relative;
    width: 100%;
}
.sa-dropdown-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1050;
    max-height: 250px;
    overflow-y: auto;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-top: 4px;
}
.sa-dropdown-item {
    padding: 0.65rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
    text-align: left;
}
.sa-dropdown-item:last-child {
    border-bottom: none;
}
.sa-dropdown-item:hover {
    background: #f3f4f6;
}
.sa-dropdown-item strong {
    display: block;
    font-size: 0.88rem;
    color: #1a1a2e;
}
.sa-dropdown-item span {
    font-size: 0.76rem;
    color: #6b7280;
}
.sa-no-results {
    padding: 1rem;
    text-align: center;
    color: #9ca3af;
    font-size: 0.85rem;
}

/* Inline History Editing */
.sa-btn-edit-log {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    font-size: 0.85rem;
    padding: 0.1rem 0.3rem;
    transition: color 0.15s;
    margin-left: 0.5rem;
}
.sa-btn-edit-log:hover {
    color: #1e1b4b;
}
.sa-select-sm, .sa-input-sm {
    width: 100%;
    padding: 0.35rem 0.6rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.82rem;
    color: #1f2937;
    background-color: #fff;
}
.sa-select-sm:focus, .sa-input-sm:focus {
    outline: none;
    border-color: #c0392b;
}
.sa-btn-save-sm {
    background: #10b981;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.35rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}
.sa-btn-save-sm:hover {
    background: #059669;
}
.sa-btn-cancel-sm {
    background: #ef4444;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.35rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}
.sa-btn-cancel-sm:hover {
    background: #dc2626;
}
</style>
