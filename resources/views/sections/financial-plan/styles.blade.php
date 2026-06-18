<style>
/* ═══════════════════════════════════════
   FINANCIAL PLAN — Styles
   ═══════════════════════════════════════ */

.fp-section {
    padding: 8rem 0 4rem;
    min-height: 80vh;
    background: #f4f6fb;
}

.fp-container { max-width: 1140px; }

/* Header */
.fp-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
    background: #fff;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.fp-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.fp-header p { color: #666; margin: 0.4rem 0 0; }

/* Badges */
.fp-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
}
.fp-badge.status-draft { background: #e2e8f0; color: #475569; }
.fp-badge.status-submitted { background: #dbeafe; color: #1e40af; }
.fp-badge.status-under_review { background: #fef3c7; color: #92400e; }
.fp-badge.status-revision_needed { background: #fee2e2; color: #991b1b; }
.fp-badge.status-approved { background: #d1fae5; color: #065f46; }

.fp-badge-sm {
    display: inline-flex; align-items: center;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.fp-badge-sm.status-pending { background: #fef3c7; color: #92400e; }
.fp-badge-sm.status-approved { background: #d1fae5; color: #065f46; }
.fp-badge-sm.status-rejected { background: #fee2e2; color: #991b1b; }

/* Alerts */
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

/* Preparation Journey */
.fp-journey {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 1.5rem 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    margin-bottom: 2rem;
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
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e2e8f0;
    transition: all 0.3s;
}
.journey-step span {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    text-align: center;
}
.journey-step.active .j-icon {
    background: #3b82f6;
    color: #fff;
    box-shadow: 0 0 0 4px #bfdbfe;
}
.journey-step.active span { color: #1e293b; }
.journey-step.completed .j-icon {
    background: #10b981;
    color: #fff;
    box-shadow: 0 0 0 2px #a7f3d0;
}
.journey-step.completed span { color: #10b981; }

.journey-line {
    flex: 1;
    height: 4px;
    background: #e2e8f0;
    margin: -25px 10px 0;
    position: relative;
    z-index: 1;
}
.journey-line.completed { background: #10b981; }

/* Layout Grid */
.fp-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}
@media(max-width:992px) {
    .fp-grid { grid-template-columns: 1fr; }
}

/* Cards */
.fp-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid #f1f5f9;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.fp-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbff;
}
.fp-card-header h5 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.fp-card-header h5 i { color: #3b82f6; }
.fp-card-body { padding: 1.5rem; }

/* Forms */
.fp-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
@media(max-width:576px) { .fp-form-grid { grid-template-columns: 1fr; } }
.fp-form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.fp-form-group label { font-size: 0.85rem; font-weight: 600; color: #475569; }

.fp-input, .fp-select, .fp-input-sm {
    width: 100%;
    padding: 0.6rem 0.9rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.fp-input:focus, .fp-select:focus, .fp-input-sm:focus {
    outline: none;
    background: #fff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,.15);
}
.fp-input-sm { padding: 0.4rem 0.6rem; font-size: 0.85rem; }

/* Accordion Tables */
.fp-accordion-btn {
    font-weight: 600;
    color: #1e293b;
    background: #fff;
    box-shadow: none !important;
}
.fp-accordion-btn:not(.collapsed) {
    color: #2563eb;
    background: #eff6ff;
}
.fp-table { width: 100%; min-width: 600px; border-collapse: collapse; }
.fp-table th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}
.fp-table td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.fp-table td:first-child { font-weight: 500; color: #334155; }
.gap-amount { font-weight: 600; font-family: monospace; font-size: 0.95rem; }

/* Document Upload */
.fp-upload-area {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2.5rem 2rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s;
}
.fp-upload-area:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}
.fp-doc-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    margin-bottom: 0.75rem;
    background: #fff;
}
.fp-doc-item:last-child { margin-bottom: 0; }
.doc-icon {
    width: 40px; height: 40px;
    background: #eff6ff; color: #3b82f6;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; margin-right: 1rem; flex-shrink: 0;
}
.doc-info { flex: 1; min-width: 0; }
.doc-info h6 { margin: 0 0 0.2rem; font-size: 0.95rem; font-weight: 600; color: #1e293b; }
.doc-info span { font-size: 0.8rem; color: #64748b; }
.doc-status { margin: 0 1rem; }
.doc-actions { display: flex; gap: 0.5rem; }
.btn-icon {
    width: 32px; height: 32px;
    border-radius: 6px; border: none; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.2s; text-decoration: none;
}
.btn-icon:hover { background: #e2e8f0; }

/* Action Buttons */
.fp-btn-save {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 0.6rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.fp-btn-save:hover { background: #f1f5f9; color: #1e293b; }
.fp-submit-area {
    padding: 1.5rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
}
.fp-btn-submit-main {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    transition: all 0.2s;
}
.fp-btn-submit-main:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
}

/* Right Sidebar: Readiness & Summary */
.readiness-circle {
    width: 140px; margin: 0 auto;
}
.circular-chart {
    display: block; margin: 0 auto; max-width: 80%; max-height: 250px;
}
.circle-bg {
    fill: none; stroke: #f1f5f9; stroke-width: 3.8;
}
.circle {
    fill: none; stroke-width: 2.8; stroke-linecap: round;
    animation: progress 1s ease-out forwards;
}
@keyframes progress {
    0% { stroke-dasharray: 0 100; }
}
.circular-chart.green .circle { stroke: #10b981; }
.circular-chart.orange .circle { stroke: #f59e0b; }
.circular-chart.red .circle { stroke: #ef4444; }
.percentage {
    fill: #1e293b; font-family: sans-serif; font-size: 0.5em; text-anchor: middle; font-weight: 700;
}

.summary-item {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 0.75rem; font-size: 0.95rem;
}
.summary-item span { color: #64748b; }
.summary-item strong { color: #1e293b; font-family: monospace; font-size: 1.05rem; }
.summary-item hr { margin: 1rem 0; border-color: #e2e8f0; }
.gap-item { margin-top: 1rem; font-size: 1.05rem; }
.gap-item strong { font-size: 1.2rem; }
</style>
