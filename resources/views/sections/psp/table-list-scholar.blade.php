<section class="section-table py-5" id="scholarship-table">
<div class="container-lg">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">Selected Program Study</h2>
        <p class="text-muted">
            Choose a scholarship from the cards above. Check <strong>one</strong> that you want to apply for, then click <strong>"Continue to Study Plan"</strong>.
        </p>
    </div>

    <!-- EMPTY STATE -->
    <div id="emptyState" class="empty-state-box" style="display:none;">
        <div class="empty-icon">🎓</div>
        <p>No study program selected.</p>
        <p class="text-muted" style="font-size:13px;">Click the <strong>"+ Choose"</strong> button on the scholarship cards above.</p>
    </div>

    <!-- TABLE WRAPPER -->
    <div id="selectedTableWrapper" style="display:none;">
        <div class="table-responsive custom-table-wrapper">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width:50px;">Apply</th>
                        <th>No</th>
                        <th>Program Study</th>
                        <th>Country</th>
                        <th>Scholarship Title</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                <tbody id="selectedTableBody">
                    <!-- Filled by JS -->
                </tbody>
            </table>
        </div>

        <p class="help-text mt-2">
            💡 You can add multiple scholarships. Select <strong>one</strong> by clicking the radio button, then press "Continue to Study Plan".
            You can <strong>change your selection anytime</strong> before submitting.
        </p>

        <!-- CTA PROCEED -->
        <div class="proceed-bar mt-3">
            <div id="proceedInfo" class="proceed-info">
                No program selected to apply.
            </div>
            <button class="btn-proceed" id="proceedBtn" disabled onclick="scrollToSubmit()">
                Continue to Study Plan →
            </button>
        </div>
    </div>

</div>

<style>
/* EMPTY STATE */
.empty-state-box {
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 20px;
    padding: 50px 20px;
    text-align: center;
    color: #6b7280;
}
.empty-icon { font-size: 48px; margin-bottom: 14px; }

/* TABLE */
.custom-table-wrapper {
    background: #fff;
    border-radius: 20px;
    padding: 10px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
}
.custom-table { border-spacing: 0 8px; border-collapse: separate; }
.custom-table tbody tr {
    background: #fff;
    transition: all 0.2s;
    cursor: pointer;
}
.custom-table tbody tr:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.custom-table tbody tr.row-selected {
    background: linear-gradient(135deg, #fff7ed, #fff0f0);
    box-shadow: 0 0 0 2px #8b0000 inset;
    border-radius: 10px;
}
.custom-table td, .custom-table th { padding: 14px 16px; border: none; }

/* RADIO */
.radio-pilih {
    width: 18px;
    height: 18px;
    accent-color: #8b0000;
    cursor: pointer;
}

/* ACTIVE BADGE */
.active-badge {
    display: inline-block;
    background: #8b0000;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 999px;
    letter-spacing: 0.5px;
    margin-left: 6px;
    vertical-align: middle;
    animation: fadePop 0.3s ease;
}
@keyframes fadePop {
    from { transform: scale(0.7); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}

/* REMOVE BUTTON */
.btn-hapus {
    background: transparent;
    border: 1px solid #ef4444;
    color: #ef4444;
    border-radius: 999px;
    padding: 5px 14px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.2s;
}
.btn-hapus:hover { background: #ef4444; color: #fff; }

/* HELP TEXT */
.help-text { font-size: 12px; color: #9ca3af; }

/* PROCEED BAR */
.proceed-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    border-radius: 16px;
    padding: 20px 28px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    flex-wrap: wrap;
    gap: 16px;
    border: 1.5px solid #f0f0f0;
    transition: border-color 0.3s;
}
.proceed-bar.has-active { border-color: #8b0000; }
.proceed-info { font-size: 14px; color: #374151; }

.btn-proceed {
    background: #8b0000;
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 12px 28px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
}
.btn-proceed:hover:not(:disabled) { background: #a50000; transform: scale(1.02); }
.btn-proceed:disabled { background: #9ca3af; cursor: not-allowed; }
</style>

<script>
const PSP_KEY        = 'psp_selected_scholarships';
const PSP_ACTIVE_KEY = 'psp_active_scholarship';

/* ---- Render tabel dari localStorage ---- */
function renderSelectedTable() {
    const list     = JSON.parse(localStorage.getItem(PSP_KEY) || '[]');
    const activeId = parseInt(localStorage.getItem(PSP_ACTIVE_KEY) || '0');
    const wrapper  = document.getElementById('selectedTableWrapper');
    const empty    = document.getElementById('emptyState');
    const tbody    = document.getElementById('selectedTableBody');

    if (list.length === 0) {
        wrapper.style.display = 'none';
        empty.style.display   = 'block';
        clearActive();
        return;
    }

    wrapper.style.display = 'block';
    empty.style.display   = 'none';

    tbody.innerHTML = list.map((s, i) => {
        const isActive = s.id === activeId;
        return `
        <tr class="${isActive ? 'row-selected' : ''}" id="row-${s.id}" onclick="setActiveScholarship(${s.id})">
            <td onclick="event.stopPropagation()">
                <input
                    type="radio"
                    name="active_scholarship"
                    class="radio-pilih"
                    value="${s.id}"
                    ${isActive ? 'checked' : ''}
                    onchange="setActiveScholarship(${s.id})"
                >
            </td>
            <td>${String(i + 1).padStart(2, '0')}</td>
            <td>
                <strong>${s.program || '-'}</strong>
                ${isActive ? '<span class="active-badge">SELECTED</span>' : ''}
            </td>
            <td>${s.country || '-'}</td>
            <td>
                <div style="font-weight:500;color:#8b0000;font-size:14px;">${s.title || '-'}</div>
                ${s.funding ? `<span style="background:#fff0f0;color:#8b0000;padding:2px 8px;border-radius:999px;font-size:11px;">${s.funding}</span>` : ''}
            </td>
            <td class="text-center" onclick="event.stopPropagation()">
                <button class="btn-hapus" onclick="hapusBeasiswa(${s.id})">✕ Remove</button>
            </td>
        </tr>
        `;
    }).join('');

    updateProceedBar(activeId, list);
}

/* ---- Set beasiswa aktif (yang akan di-submit) ---- */
function setActiveScholarship(id) {
    const list = JSON.parse(localStorage.getItem(PSP_KEY) || '[]');
    const s    = list.find(item => item.id === id);
    if (!s) return;

    // Update radio + row highlight
    document.querySelectorAll('.custom-table tbody tr').forEach(r => r.classList.remove('row-selected'));
    document.querySelectorAll('.radio-pilih').forEach(r => r.checked = false);

    const row   = document.getElementById('row-' + id);
    const radio = document.querySelector(`.radio-pilih[value="${id}"]`);
    if (row)   row.classList.add('row-selected');
    if (radio) radio.checked = true;

    // Persist
    localStorage.setItem(PSP_ACTIVE_KEY, id);
    localStorage.setItem('psp_active_data', JSON.stringify(s));

    // Update DIPILIH badge (re-render the name cell only)
    document.querySelectorAll('td strong').forEach(el => {
        const badge = el.parentElement.querySelector('.active-badge');
        if (badge) badge.remove();
    });
    if (row) {
        const nameCell = row.querySelectorAll('td')[2];
        if (nameCell && !nameCell.querySelector('.active-badge')) {
            const badge = document.createElement('span');
            badge.className = 'active-badge';
            badge.textContent = 'SELECTED';
            nameCell.appendChild(badge);
        }
    }

    updateProceedBar(id, list);
    window.dispatchEvent(new Event('pspActiveChanged'));
}

/* ---- Clear active state ---- */
function clearActive() {
    localStorage.removeItem(PSP_ACTIVE_KEY);
    localStorage.removeItem('psp_active_data');
    updateProceedBar(0, []);
    window.dispatchEvent(new Event('pspActiveChanged'));
}

/* ---- Update proceed bar ---- */
function updateProceedBar(activeId, list) {
    const btn    = document.getElementById('proceedBtn');
    const info   = document.getElementById('proceedInfo');
    const bar    = document.querySelector('.proceed-bar');
    const active = list.find(s => s.id === activeId);

    if (active) {
        info.innerHTML = `✅ Selected: <strong>${active.program}</strong> — <em>${active.title}</em>
            &nbsp;<span style="font-size:12px;color:#8b0000;cursor:pointer;" onclick="clearActive()">[ Cancel ]</span>`;
        if (btn) btn.disabled = false;
        if (bar) bar.classList.add('has-active');
    } else {
        info.innerHTML = 'Check one of the programs to continue.';
        if (btn) btn.disabled = true;
        if (bar) bar.classList.remove('has-active');
    }
}

/* ---- Hapus dari daftar ---- */
function hapusBeasiswa(id) {
    let list = JSON.parse(localStorage.getItem(PSP_KEY) || '[]');
    list = list.filter(s => s.id !== id);
    localStorage.setItem(PSP_KEY, JSON.stringify(list));

    const activeId = parseInt(localStorage.getItem(PSP_ACTIVE_KEY) || '0');
    if (activeId === id) clearActive();

    renderSelectedTable();
    if (typeof updatePilihButtons === 'function') updatePilihButtons();
    window.dispatchEvent(new Event('pspSelectionChanged'));
}

/* ---- Scroll ke form submit ---- */
function scrollToSubmit() {
    const section = document.getElementById('submit-study-plan');
    if (section) section.scrollIntoView({ behavior: 'smooth' });
}

window.addEventListener('pspSelectionChanged', renderSelectedTable);
renderSelectedTable();
</script>

</section>
