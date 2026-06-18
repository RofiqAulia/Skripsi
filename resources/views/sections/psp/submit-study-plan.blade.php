<section class="section-submit py-5" id="submit-study-plan">
<div class="container-lg">

    @if(session('success'))
    <div class="alert-success-psp">✅ {{ session('success') }}</div>
    @endif

    <div class="text-center mb-5">
        <h2 class="fw-bold">Submit Research Topic</h2>
        <p class="text-muted">Fill in the research topic details <strong>and/or</strong> upload supporting documents.</p>
    </div>

    <!-- SELECTED SCHOLARSHIP SUMMARY -->
    <div id="submitScholarshipSummary" class="scholarship-summary-box mb-4" style="display:none;">
        <div class="summary-header">📚 Selected Scholarship:</div>
        <div id="summaryContent" class="summary-card"></div>
    </div>

    <div id="noSelectionWarning" class="no-selection-warning mb-4">
        ⚠️ You haven't selected a scholarship. Select from the cards above, check one, then click <strong>"Continue to Research Topic"</strong>.
        <br><a href="#scholarship-table" style="color:#92400e;font-weight:600;">↑ Back to scholarship list</a>
    </div>

    <!-- FORM -->
    <form id="studyForm" method="POST" action="{{ route('psp.apply') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="program_study_id" id="scholarshipIdInput" value="">

        <div class="submit-grid">

            <!-- LEFT: Text -->
            <div class="submit-card">
                <div class="submit-card-header">
                    <span class="submit-card-icon">✏️</span>
                    <div>
                        <h4>Research Topic</h4>
                        <p>Describe your intended research topic, methodology, and objectives. <strong>Max. 2000 characters.</strong></p>
                    </div>
                </div>

                <textarea
                    id="studyInput"
                    name="study_plan_text"
                    rows="7"
                    maxlength="2000"
                    placeholder="Example: I plan to research the impact of artificial intelligence on sustainable energy production..."
                >{{ old('study_plan_text') }}</textarea>

                @error('study_plan_text')
                    <small class="error-text">{{ $message }}</small>
                @enderror
                <small id="charCount" class="char-count">0 / 2000</small>
            </div>

            <!-- RIGHT: File Upload -->
            <div class="submit-card">
                <div class="submit-card-header">
                    <span class="submit-card-icon">📎</span>
                    <div>
                        <h4>Supporting Documents</h4>
                        <p>PDF, Word, Excel, PPT · Max. <strong>20MB per file</strong> · Multiple files allowed.</p>
                    </div>
                </div>

                <div class="file-drop-zone" id="fileDropZone" onclick="document.getElementById('fileInput').click()">
                    <div class="drop-icon">📂</div>
                    <div class="drop-text">Click or drag & drop files here</div>
                    <div class="drop-sub">PDF · Word · Excel · PPT</div>
                </div>

                <input
                    type="file"
                    id="fileInput"
                    name="study_plan_files[]"
                    multiple
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    style="display:none;"
                    onchange="handleFileSelect(this)"
                >

                <div id="fileList" class="file-list mt-3"></div>

                @error('study_plan_files')
                    <small class="error-text">{{ $message }}</small>
                @enderror
                @error('study_plan_files.*')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="submit-footer mt-4">
            <p class="submit-note">* Fill in at least one: research topic text or upload document file.</p>
            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                🚀 Submit Research Topic
            </button>
        </div>

    </form>

</div>

<!-- TOAST -->
@if(session('success'))
<div id="toast" class="toast show">✅ {{ session('success') }}</div>
@else
<div id="toast" class="toast"></div>
@endif

<style>
.section-submit { background: #f8f9fa; }

/* SUMMARY */
.scholarship-summary-box {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
.summary-header { font-weight: 600; color: #8b0000; margin-bottom: 12px; font-size: 14px; }
.summary-card {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
}
.summary-chip {
    display: flex;
    flex-direction: column;
    gap: 2px;
    background: #fff0f0;
    border-radius: 12px;
    padding: 10px 16px;
    min-width: 120px;
}
.summary-chip small { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }
.summary-chip strong { font-size: 13px; color: #8b0000; }

.no-selection-warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 14px 20px;
    color: #92400e;
    font-size: 14px;
}

/* GRID */
.submit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

/* CARD */
.submit-card {
    background: #fff;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.submit-card-header {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}
.submit-card-icon { font-size: 28px; flex-shrink: 0; margin-top: 2px; }
.submit-card-header h4 { font-size: 16px; font-weight: 700; margin: 0 0 4px; }
.submit-card-header p { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.5; }

/* TEXTAREA */
textarea {
    width: 100%;
    border-radius: 14px;
    border: 1px solid #ddd;
    padding: 14px;
    font-size: 14px;
    resize: vertical;
    transition: 0.3s;
    font-family: inherit;
    flex: 1;
}
textarea:focus {
    outline: none;
    border-color: #8b0000;
    box-shadow: 0 0 0 3px rgba(139,0,0,0.1);
}
.error-text { color: #dc2626; font-size: 12px; display: block; margin-top: 4px; }
.char-count { font-size: 12px; color: #9ca3af; text-align: right; display: block; }

/* FILE DROP */
.file-drop-zone {
    border: 2px dashed #d1d5db;
    border-radius: 16px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: 0.2s;
    background: #f9fafb;
}
.file-drop-zone:hover { border-color: #8b0000; background: #fff8f8; }
.drop-icon { font-size: 32px; margin-bottom: 8px; }
.drop-text { font-weight: 600; color: #374151; margin-bottom: 4px; font-size: 14px; }
.drop-sub { font-size: 12px; color: #9ca3af; }

.file-list { display: flex; flex-direction: column; gap: 8px; }
.file-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f3f4f6;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
}
.file-item .file-icon { font-size: 18px; }
.file-item .file-name { flex: 1; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.file-item .file-size { color: #9ca3af; white-space: nowrap; }
.file-remove {
    background: none; border: none; color: #ef4444;
    cursor: pointer; font-size: 16px; padding: 0; flex-shrink: 0;
}

/* FOOTER */
.submit-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.submit-note { font-size: 12px; color: #9ca3af; margin: 0; }

.btn-submit {
    background: #8b0000;
    color: #fff;
    border-radius: 999px;
    padding: 14px 40px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-submit:hover:not(:disabled) { background: #a50000; }
.btn-submit:disabled { background: #9ca3af; cursor: not-allowed; }

/* ALERT */
.alert-success-psp {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 14px 20px;
    margin-bottom: 20px;
}

/* TOAST */
.toast {
    position: fixed; bottom: 30px; right: 30px;
    background: #22c55e; color: #fff;
    padding: 14px 20px; border-radius: 12px;
    opacity: 0; transform: translateY(20px);
    transition: 0.3s; z-index: 9999;
}
.toast.show { opacity: 1; transform: translateY(0); }

@media (max-width: 768px) {
    .submit-grid { grid-template-columns: 1fr; }
    .submit-footer { flex-direction: column; align-items: stretch; }
    .btn-submit { width: 100%; text-align: center; }
}
</style>

<script>
/* ===== CHAR COUNT ===== */
const studyInput = document.getElementById('studyInput');
const charCount  = document.getElementById('charCount');
if (studyInput) {
    charCount.innerText = `${studyInput.value.length} / 2000`;
    studyInput.addEventListener('input', () => {
        const l = studyInput.value.length;
        charCount.innerText = `${l} / 2000`;
        charCount.style.color = l > 2000 ? '#dc2626' : '#9ca3af';
        validateForm();
    });
}

/* ===== FILE HANDLING ===== */
let selectedFiles = [];

function handleFileSelect(el) {
    Array.from(el.files).forEach(f => {
        if (!selectedFiles.find(sf => sf.name === f.name && sf.size === f.size)) {
            selectedFiles.push(f);
        }
    });
    el.value = ''; // reset so same file can be re-added after removal
    renderFileList();
    validateForm();
}

function renderFileList() {
    const container = document.getElementById('fileList');
    container.innerHTML = selectedFiles.map((f, i) => `
        <div class="file-item">
            <span class="file-icon">${getFileIcon(f.name)}</span>
            <span class="file-name">${f.name}</span>
            <span class="file-size">${(f.size / 1024 / 1024).toFixed(2)} MB</span>
            <button class="file-remove" onclick="removeFile(${i})" type="button">✕</button>
        </div>
    `).join('');
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileList();
    validateForm();
}

function getFileIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext)) return '📄';
    if (['doc','docx'].includes(ext)) return '📝';
    if (['xls','xlsx'].includes(ext)) return '📊';
    if (['ppt','pptx'].includes(ext)) return '📽️';
    return '📎';
}

/* ===== DRAG & DROP ===== */
const dropZone = document.getElementById('fileDropZone');
if (dropZone) {
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor = '#8b0000'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = '#d1d5db'; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.borderColor = '#d1d5db';
        Array.from(e.dataTransfer.files).forEach(f => {
            if (!selectedFiles.find(sf => sf.name === f.name)) selectedFiles.push(f);
        });
        renderFileList();
        validateForm();
    });
}

/* Attach files on submit */
document.getElementById('studyForm').addEventListener('submit', function() {
    if (selectedFiles.length > 0) {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        document.getElementById('fileInput').files = dt.files;
    }
});

/* ===== SCHOLARSHIP SUMMARY from localStorage ===== */
function renderSubmitSummary() {
    const activeRaw = localStorage.getItem('psp_active_data');
    const summary   = document.getElementById('submitScholarshipSummary');
    const noWarn    = document.getElementById('noSelectionWarning');
    const content   = document.getElementById('summaryContent');
    const idInput   = document.getElementById('scholarshipIdInput');

    if (!activeRaw) {
        summary.style.display = 'none';
        noWarn.style.display  = 'block';
        idInput.value = '';
    } else {
        const active = JSON.parse(activeRaw);
        noWarn.style.display  = 'none';
        summary.style.display = 'block';
        idInput.value = active.id;

        content.innerHTML = `
            <div class="summary-chip"><small>Scholarship</small><strong>${active.title || '-'}</strong></div>
            <div class="summary-chip"><small>Country</small><strong>${active.country || '-'}</strong></div>
            <div class="summary-chip"><small>Funding</small><strong>${active.funding || '-'}</strong></div>
            <div class="summary-chip"><small>Program</small><strong>${active.program || '-'}</strong></div>
            <div class="summary-chip" style="justify-content:center;background:#fff0f0;">
                <a href="#scholarship-table"
                   style="color:#8b0000;font-size:12px;font-weight:600;text-decoration:none;"
                   onclick="document.getElementById('scholarship-table').scrollIntoView({behavior:'smooth'});return false;">
                    ✏️ Change Selection
                </a>
            </div>
        `;
    }
    validateForm();
}

/* ===== VALIDATE FORM ===== */
function validateForm() {
    const hasScholarship = !!document.getElementById('scholarshipIdInput').value;
    const hasText  = studyInput && studyInput.value.trim().length >= 5;
    const hasFiles = selectedFiles.length > 0;

    // Must have a scholarship selected AND at least text OR files
    const isValid = hasScholarship && (hasText || hasFiles);
    document.getElementById('submitBtn').disabled = !isValid;
}

window.addEventListener('pspActiveChanged', renderSubmitSummary);
renderSubmitSummary();

/* AUTO-HIDE TOAST */
const toast = document.getElementById('toast');
if (toast && toast.classList.contains('show')) {
    setTimeout(() => toast.classList.remove('show'), 3500);
}
</script>

</section>