<style>
/* ═══ MODERN SAAS DESIGN SYSTEM ═══ */
:root {
    /* Light Mode Variables */
    --bg-body: #f3f4f6; /* Soft gray background */
    --bg-card: rgba(255, 255, 255, 0.75);
    --bg-card-hover: rgba(255, 255, 255, 0.95);
    --bg-muted: rgba(0, 0, 0, 0.03);
    
    --border-color: rgba(255, 255, 255, 0.5);
    --border-strong: rgba(0, 0, 0, 0.06);
    
    --text-main: #111827;
    --text-muted: #6b7280;
    --text-inverse: #ffffff;
    
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.03);
    --shadow-md: 0 8px 24px -6px rgba(0,0,0,0.05);
    --shadow-lg: 0 16px 40px -8px rgba(0,0,0,0.08);
    --shadow-hover: 0 20px 40px -8px rgba(0,0,0,0.12);
    
    --radius-sm: 10px;
    --radius-md: 16px;
    --radius-lg: 24px;
    --radius-full: 9999px;
    
    --blur-intensity: blur(16px);
    
    /* Accents */
    --primary: #8b0000;      /* Deep Red (SIG) */
    --primary-light: #fce8e8;
    --primary-grad: linear-gradient(135deg, #a60000, #8b0000);
    
    --success: #10b981;
    --success-light: #d1fae5;
    --success-grad: linear-gradient(135deg, #34d399, #10b981);
    
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --warning-grad: linear-gradient(135deg, #fbbf24, #f59e0b);
    
    --danger: #ef4444;
    --danger-light: #fee2e2;
    --danger-grad: linear-gradient(135deg, #f87171, #ef4444);
    
    --info: #0ea5e9;
    --info-light: #e0f2fe;
    --info-grad: linear-gradient(135deg, #38bdf8, #0ea5e9);
}

@media (prefers-color-scheme: dark) {
    :root {
        --bg-body: #09090b; /* Zinc 950 */
        --bg-card: rgba(24, 24, 27, 0.65); /* Zinc 900 */
        --bg-card-hover: rgba(39, 39, 42, 0.85); /* Zinc 800 */
        --bg-muted: rgba(255, 255, 255, 0.03);
        
        --border-color: rgba(255, 255, 255, 0.08);
        --border-strong: rgba(255, 255, 255, 0.12);
        
        --text-main: #f4f4f5;
        --text-muted: #a1a1aa;
        
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.2);
        --shadow-md: 0 8px 24px -6px rgba(0,0,0,0.4);
        --shadow-hover: 0 20px 40px -8px rgba(0,0,0,0.6);
        
        /* Adjusting light accent colors for dark mode */
        --primary-light: rgba(79, 70, 229, 0.2);
        --success-light: rgba(16, 185, 129, 0.2);
        --warning-light: rgba(245, 158, 11, 0.2);
        --danger-light: rgba(239, 68, 68, 0.2);
        --info-light: rgba(14, 165, 233, 0.2);
    }
}

/* ═══ BASE & UTILITIES ═══ */
body {
    background-color: var(--bg-body) !important;
    color: var(--text-main);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.section-dashboard {
    padding: 100px 0 80px;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

/* Background Ambient Glow */
.section-dashboard::before,
.section-dashboard::after {
    content: ''; position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.4; z-index: 0; pointer-events: none;
}
.section-dashboard::before {
    top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, rgba(255,255,255,0) 70%);
}
.section-dashboard::after {
    bottom: -10%; right: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, rgba(255,255,255,0) 70%);
}

.dash-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }

.glass-card {
    background: var(--bg-card);
    backdrop-filter: var(--blur-intensity);
    -webkit-backdrop-filter: var(--blur-intensity);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.glass-card:hover {
    background: var(--bg-card-hover);
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

/* ═══ HEADER ═══ */
.dash-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 40px; margin-top: 20px; }
.dash-header-title h1 { font-size: 32px; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 4px; color: var(--text-main); }
.dash-header-title p { font-size: 15px; color: var(--text-muted); margin: 0; }
.dash-date {
    display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
    background: var(--bg-card); backdrop-filter: var(--blur-intensity);
    border: 1px solid var(--border-color); border-radius: var(--radius-full);
    font-size: 14px; font-weight: 500; color: var(--text-main); box-shadow: var(--shadow-sm);
}

/* ═══ STAT CARDS ═══ */
.stat-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 32px; }
.stat-card { padding: 20px; display: flex; flex-direction: column; gap: 12px; position: relative; }
.stat-icon {
    width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--text-inverse); box-shadow: var(--shadow-md);
}
.stat-card .bg-blue { background: var(--info-grad); }
.stat-card .bg-amber { background: var(--warning-grad); }
.stat-card .bg-green { background: var(--success-grad); }
.stat-card .bg-red { background: var(--danger-grad); }
.stat-card .bg-indigo { background: var(--primary-grad); }

.stat-info { display: flex; flex-direction: column; gap: 2px; }
.stat-label { font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-size: 28px; font-weight: 800; color: var(--text-main); line-height: 1.1; margin: 4px 0; }
.stat-sub { font-size: 12px; color: var(--text-muted); font-weight: 500; }

.stat-highlight { position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.2); }
.stat-highlight::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(244,63,94,0.1) 0%, rgba(225,29,72,0.8) 100%); z-index: -1;
}
.stat-highlight .stat-value, .stat-highlight .stat-label, .stat-highlight .stat-sub { color: #fff; }
.progress-thin { height: 6px; background: rgba(255,255,255,0.2); border-radius: var(--radius-full); margin-top: 8px; width: 100%; overflow: hidden; }
.progress-thin div { height: 100%; background: #fff; border-radius: var(--radius-full); transition: width 1s ease-in-out; }

/* ═══ GRID LAYOUT ═══ */
.dash-grid { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 24px; align-items: start; }
.dash-left, .dash-right { display: flex; flex-direction: column; gap: 24px; }

/* ═══ DASHBOARD CARDS ═══ */
.dash-card { padding: 28px; }
.card-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.card-head h4 { font-size: 18px; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 10px; }
.card-head h4 i { font-size: 20px; color: var(--primary); padding: 8px; background: var(--primary-light); border-radius: 10px; }
.card-link { font-size: 14px; font-weight: 600; color: var(--primary); text-decoration: none; padding: 6px 12px; border-radius: var(--radius-full); transition: 0.2s; background: var(--primary-light); }
.card-link:hover { background: var(--primary); color: #fff; }

/* ═══ DOCUMENT LIST ═══ */
.doc-list { display: flex; flex-direction: column; gap: 12px; }
.doc-item {
    display: flex; align-items: center; gap: 16px; padding: 14px 16px; border-radius: 14px;
    background: var(--bg-muted); border: 1px solid transparent; transition: 0.2s;
}
.doc-item:hover { border-color: var(--border-strong); transform: translateX(4px); }
.doc-status-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }

.st-approved { background: var(--success-light); color: var(--success); }
.st-pending { background: var(--warning-light); color: var(--warning); }
.st-rejected { background: var(--danger-light); color: var(--danger); }
.st-empty { background: var(--bg-body); color: var(--text-muted); border: 1px dashed var(--border-strong); }

.doc-info { flex: 1; }
.doc-name { font-size: 15px; font-weight: 600; color: var(--text-main); display: block; margin-bottom: 2px; }
.doc-info small { font-size: 13px; color: var(--text-muted); }

/* ═══ MENTOR CARD ═══ */
.mentor-card {
    display: flex; align-items: center; gap: 20px; padding: 20px; border-radius: 16px;
    background: linear-gradient(135deg, var(--bg-muted) 0%, transparent 100%);
    border: 1px solid var(--border-strong);
}
.mentor-avatar img, .avatar-placeholder {
    width: 64px; height: 64px; border-radius: var(--radius-full); object-fit: cover;
    box-shadow: var(--shadow-sm); border: 2px solid var(--bg-card);
}
.avatar-placeholder { background: var(--bg-body); display: flex; align-items: center; justify-content: center; font-size: 28px; color: var(--text-muted); }
.mentor-info h5 { font-size: 18px; font-weight: 700; margin: 0 0 4px; color: var(--text-main); }
.mentor-info p { font-size: 14px; color: var(--text-muted); margin: 0; }

/* ═══ TABLE ═══ */
.session-table-wrap { overflow-x: auto; margin: 0 -8px; padding: 0 8px; }
.session-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
.session-table th { padding: 0 16px 12px; text-align: left; font-weight: 600; color: var(--text-muted); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
.session-table td { padding: 16px; background: var(--bg-muted); color: var(--text-main); font-size: 14px; transition: 0.2s; }
.session-table td:first-child { border-radius: 12px 0 0 12px; }
.session-table td:last-child { border-radius: 0 12px 12px 0; }
.session-table tr:hover td { background: var(--border-strong); }

.badge-base { padding: 6px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 700; text-transform: capitalize; letter-spacing: 0.5px; }
.badge-done, .badge-approved { background: var(--success-light); color: var(--success); }
.badge-confirmed, .badge-submitted { background: var(--info-light); color: var(--info); }
.badge-pending, .badge-revision { background: var(--warning-light); color: var(--warning); }
.badge-cancelled, .badge-rejected { background: var(--danger-light); color: var(--danger); }
.badge-draft { background: var(--bg-body); color: var(--text-muted); }

/* ═══ CALENDAR ═══ */
.cal-header { text-align: center; margin-bottom: 20px; font-size: 16px; font-weight: 700; color: var(--text-main); }
.cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; text-align: center; }
.cal-day-name { font-size: 12px; font-weight: 600; color: var(--text-muted); padding: 8px 0; text-transform: uppercase; }
.cal-cell {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: 12px;
    font-size: 14px; font-weight: 500; color: var(--text-main); position: relative; transition: 0.2s;
    background: transparent;
}
.cal-cell:not(.empty):hover { background: var(--bg-muted); cursor: pointer; }
.cal-cell.is-today { background: var(--primary); color: #fff; font-weight: 700; box-shadow: var(--shadow-sm); }
.cal-cell.has-event { border: 2px solid var(--success-light); color: var(--text-main); font-weight: 700; }
.cal-cell.has-event:hover { background: var(--success-light); transform: scale(1.05); }
.cal-cell.is-today.has-event { background: var(--primary-grad); border-color: transparent; }
.cal-dot { position: absolute; bottom: 6px; width: 6px; height: 6px; border-radius: 50%; background: var(--success); }
.cal-cell.is-today .cal-dot { background: #fff; }

.cal-event-popup {
    position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 50;
    background: rgba(17, 24, 39, 0.9); backdrop-filter: blur(8px); color: #fff;
    padding: 12px 24px; border-radius: var(--radius-full); font-size: 14px; font-weight: 500;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: popupSlide 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes popupSlide { from { opacity: 0; transform: translate(-50%, 20px); } to { opacity: 1; transform: translate(-50%, 0); } }

/* ═══ UPCOMING EVENTS ═══ */
.upcoming-list { margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--border-color); }
.upcoming-list h6 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 16px; }
.upcoming-item { display: flex; gap: 16px; align-items: center; padding: 12px; border-radius: 12px; transition: 0.2s; }
.upcoming-item:hover { background: var(--bg-muted); }
.upcoming-date-box { width: 56px; height: 56px; background: var(--bg-card); border: 1px solid var(--border-strong); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: var(--shadow-sm); }
.up-day { font-size: 20px; font-weight: 800; color: var(--primary); line-height: 1; }
.up-month { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-top: 2px; }
.upcoming-info { flex: 1; }
.upcoming-info strong { font-size: 15px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 4px; }
.upcoming-info small { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-bottom: 2px; }

.upcoming-poster-thumb { width: 64px; height: 64px; border-radius: 12px; overflow: hidden; flex-shrink: 0; cursor: pointer; position: relative; box-shadow: var(--shadow-sm); transition: 0.2s; }
.upcoming-poster-thumb:hover { transform: scale(1.05); box-shadow: var(--shadow-md); }
.upcoming-poster-thumb img { width: 100%; height: 100%; object-fit: cover; }
.poster-zoom-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.4); opacity: 0; transition: 0.2s; color: #fff; font-size: 20px; }
.upcoming-poster-thumb:hover .poster-zoom-icon { opacity: 1; }

/* ═══ PSP DETAILS ═══ */
.psp-status-box { text-align: center; margin-bottom: 24px; }
.psp-badge { display: inline-block; padding: 8px 24px; border-radius: var(--radius-full); font-size: 14px; font-weight: 700; letter-spacing: 0.5px; }
.psp-details { display: flex; flex-direction: column; gap: 12px; background: var(--bg-muted); padding: 20px; border-radius: 16px; border: 1px solid var(--border-strong); }
.psp-row { display: flex; justify-content: space-between; font-size: 14px; align-items: center; }
.psp-row span { color: var(--text-muted); font-weight: 500; }
.psp-row strong { color: var(--text-main); font-weight: 700; text-align: right; max-width: 65%; }

/* ═══ EMPTY HINTS & BUTTONS ═══ */
.empty-hint { text-align: center; padding: 40px 20px; color: var(--text-muted); background: var(--bg-muted); border-radius: 16px; border: 1px dashed var(--border-strong); }
.empty-hint i { font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.5; }
.empty-hint p { font-size: 15px; margin-bottom: 20px; font-weight: 500; }
.btn-sm-action {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 24px; background: var(--primary); color: #fff !important;
    border-radius: var(--radius-full); font-size: 14px; font-weight: 600;
    text-decoration: none; transition: 0.2s; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
}
.btn-sm-action:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.6); background: #4338ca; }

/* ═══ SCHOLARSHIP STATS ═══ */
.scholarship-stats { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
.stat-pill { padding: 6px 16px; border-radius: var(--radius-full); font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
.stat-pill.success { background: var(--success-light); color: var(--success); }
.stat-pill.neutral { background: var(--bg-muted); color: var(--text-main); border: 1px solid var(--border-strong); }

/* ═══ POSTER LIGHTBOX ═══ */
.poster-lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.8); backdrop-filter: blur(12px); align-items: center; justify-content: center; }
.poster-lightbox.active { display: flex; animation: lbFadeIn 0.3s ease; }
@keyframes lbFadeIn { from{opacity:0; backdrop-filter: blur(0);} to{opacity:1; backdrop-filter: blur(12px);} }
.lightbox-content { position: relative; max-width: 90vw; max-height: 90vh; display: flex; flex-direction: column; align-items: center; gap: 20px; }
.lightbox-content img { max-width: 100%; max-height: 80vh; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); object-fit: contain; animation: lbZoomIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
@keyframes lbZoomIn { from{transform:scale(0.95);opacity:0} to{transform:scale(1);opacity:1} }
.lightbox-close { position: absolute; top: -20px; right: -20px; z-index: 10; width: 44px; height: 44px; border-radius: 50%; border: none; background: #fff; color: #111; font-size: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 20px rgba(0,0,0,0.3); transition: 0.2s; }
.lightbox-close:hover { transform: scale(1.1) rotate(90deg); }
.lightbox-actions { display: flex; align-items: center; gap: 20px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 12px 24px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.2); }
.lightbox-title { color: #fff; font-size: 16px; font-weight: 600; }
.lightbox-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; background: #fff; color: #111; border-radius: 50px; font-size: 14px; font-weight: 600; text-decoration: none; transition: 0.2s; }
.lightbox-btn:hover { background: #f3f4f6; transform: translateY(-2px); color: #111; }

/* ═══ RESPONSIVE ═══ */
@media(max-width: 1200px) {
    .stat-row { grid-template-columns: repeat(3, 1fr); }
}
@media(max-width: 992px) {
    .dash-grid { grid-template-columns: 1fr; gap: 24px; }
    .stat-row { grid-template-columns: repeat(3, 1fr); }
}
@media(max-width: 768px) {
    .stat-row { grid-template-columns: repeat(2, 1fr); }
    .dash-header { flex-direction: column; align-items: flex-start; }
    .dash-card { padding: 20px; }
    .session-table-wrap { margin: 0; padding: 0; }
}
@media(max-width: 480px) {
    .stat-row { grid-template-columns: 1fr; }
    .stat-row .stat-card { grid-column: span 1 !important; }
}
</style>
