{{-- ================================================================
     CUSTOM OVERLAY: Suggest New Program Study
     Pure CSS + JS — no Bootstrap modal dependency
================================================================ --}}

<style>
/* ── Overlay backdrop ── */
#psr-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0,0,0,0.55);
    align-items: center;
    justify-content: center;
    padding: 20px;
}
#psr-overlay.psr-open {
    display: flex;
    animation: psrFadeIn .2s ease;
}
@keyframes psrFadeIn { from { opacity:0 } to { opacity:1 } }

/* ── Dialog box ── */
#psr-dialog {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 820px;
    max-height: 90vh;          /* ← cap */
    display: flex;
    flex-direction: column;    /* header | body | footer */
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.25);
    animation: psrSlideUp .25s ease;
}
@keyframes psrSlideUp { from { transform:translateY(30px);opacity:0 } to { transform:translateY(0);opacity:1 } }

/* ── Header (fixed) ── */
#psr-dialog .psr-hd {
    background: linear-gradient(135deg, #8b0000, #c0392b);
    padding: 20px 26px;
    flex-shrink: 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    border-radius: 18px 18px 0 0;
}
#psr-dialog .psr-hd h5 { color:#fff; font-weight:700; font-size:17px; margin:0; }
#psr-dialog .psr-hd p  { color:rgba(255,255,255,.75); font-size:12px; margin:4px 0 0; }
.psr-close-btn {
    background: rgba(255,255,255,.2);
    border: none;
    border-radius: 50%;
    width: 30px; height: 30px;
    color: #fff;
    font-size: 15px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background .15s;
}
.psr-close-btn:hover { background: rgba(255,255,255,.35); }

/* ── Body (SCROLLABLE) ── */
#psr-dialog .psr-bd {
    flex: 1 1 auto;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
    padding: 22px 24px;
    background: #f4f6f9;
}

/* ── Footer (fixed) ── */
#psr-dialog .psr-ft {
    flex-shrink: 0;
    padding: 14px 24px;
    background: #fff;
    border-top: 1px solid #e8eaf0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    border-radius: 0 0 18px 18px;
}

/* ── Section cards ── */
.psr-card {
    background: #fff;
    border-radius: 13px;
    padding: 18px 20px;
    margin-bottom: 13px;
    border: 1px solid #eaedf0;
}
.psr-card:last-child { margin-bottom:0; }
.psr-card-title {
    font-size: 13px; font-weight:700; color:#1f2937;
    margin-bottom: 14px; padding-bottom:10px;
    border-bottom: 1.5px solid #f0f2f5;
    display:flex; align-items:center; gap:7px;
}

/* ── 2-col grid ── */
.psr-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.psr-grid .w2 { grid-column: 1 / -1; }
@media(max-width:580px){
    .psr-grid { grid-template-columns:1fr; }
    .psr-grid .w2 { grid-column:auto; }
}

/* ── Field ── */
.psr-lbl {
    display:block; font-size:11.5px; font-weight:600;
    color:#374151; margin-bottom:5px;
}
.psr-lbl .r { color:#dc2626; }
.psr-lbl .o { color:#9ca3af; font-weight:400; }

.psr-inp, .psr-sel, .psr-ta {
    display:block; width:100%;
    padding: 9px 12px; font-size:13px; font-family:inherit;
    color:#111827; background:#fff;
    border: 1.5px solid #d1d5db; border-radius:9px;
    transition: border-color .18s, box-shadow .18s;
    box-sizing: border-box;
}
.psr-inp:focus, .psr-sel:focus, .psr-ta:focus {
    border-color:#8b0000;
    box-shadow:0 0 0 3px rgba(139,0,0,.1);
    outline:none;
}
.psr-ta  { resize:vertical; min-height:72px; }
.psr-sel {
    cursor:pointer; -webkit-appearance:none; appearance:none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23aaa' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 11px center; padding-right:30px;
}

/* ── Pill checkboxes ── */
.psr-pills { display:flex; flex-wrap:wrap; gap:7px; margin-top:5px; }
.psr-pill {
    display:inline-flex; align-items:center; gap:6px;
    background:#f3f4f6; border:1.5px solid #d1d5db; border-radius:50px;
    padding:5px 13px; cursor:pointer; font-size:12px; font-weight:600;
    color:#374151; transition:all .15s; user-select:none;
}
.psr-pill input[type=checkbox] { display:none; }
.psr-pill:has(input:checked) { border-color:#8b0000; background:#fff5f5; color:#8b0000; }
.psr-pill:hover { border-color:#8b0000; background:#fff5f5; color:#8b0000; }

/* ── Buttons ── */
.psr-btn {
    display:inline-flex; align-items:center; gap:7px;
    border:none; border-radius:50px; padding:10px 22px;
    font-size:13.5px; font-weight:700; cursor:pointer; transition:all .18s;
}
.psr-btn-cancel { background:#f0f2f5; color:#6b7280; border:1.5px solid #d1d5db; }
.psr-btn-cancel:hover { background:#e5e7eb; }
.psr-btn-submit { background:#8b0000; color:#fff; }
.psr-btn-submit:hover { background:#6a0000; transform:translateY(-1px); }

/* ── Success toast ── */
#psr-toast {
    display:none; position:fixed; bottom:30px; right:30px; z-index:100000;
    background:#064e3b; color:#fff; padding:14px 20px; border-radius:12px;
    font-size:14px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.2);
    animation:psrFadeIn .3s ease;
}
</style>

{{-- ── OVERLAY ─────────────────────────────────────────── --}}
<div id="psr-overlay" onclick="psrCloseOnBackdrop(event)">
  <div id="psr-dialog" role="dialog" aria-modal="true" aria-labelledby="psrTitle">

    {{-- Header --}}
    <div class="psr-hd">
      <div>
        <h5 id="psrTitle">🏛 Suggest New Program Study</h5>
        <p>Your submission will be reviewed by an admin before appearing in the system.</p>
      </div>
      <button class="psr-close-btn" onclick="psrClose()" aria-label="Close">✕</button>
    </div>

    {{-- Scrollable body --}}
    <div class="psr-bd">
      <form method="POST" action="{{ route('program-study-request.store') }}" id="psrForm">
        @csrf

        {{-- 1. General --}}
        <div class="psr-card">
          <div class="psr-card-title">📚 General Information</div>
          <div class="psr-grid">
            <div class="w2">
              <label class="psr-lbl">Program Name <span class="r">*</span></label>
              <input type="text" name="name" class="psr-inp" required placeholder="e.g. Master of Computer Science">
            </div>
            <div>
              <label class="psr-lbl">Scholarship <span class="o">(optional)</span></label>
              <input type="text" name="scholarship" class="psr-inp" placeholder="e.g. LPDP, Fulbright">
            </div>
            <div>
              <label class="psr-lbl">Competency <span class="r">*</span></label>
              <select name="competency" class="psr-sel" required>
                <option value="">-- Select Competency --</option>
                <option>Advance Mining Engineering</option>
                <option>Advance Process Engineering</option>
                <option>Advance Digital analytics &amp; Data Science</option>
                <option>Artificial Intelligence</option>
                <option>Robotic Process Automation</option>
                <option>Strategic Transformation &amp; Project Management</option>
                <option>Strategic Portfolio &amp; Investment Management</option>
                <option>Strategic &amp; Management</option>
                <option>Business &amp; Administration</option>
                <option>Business Analysis</option>
                <option>Business Development</option>
                <option>Marketing &amp; Sales Strategy</option>
                <option>Digital Marketing</option>
                <option>Sociology &amp; Psychology</option>
                <option>Strategic Human Capital &amp; Psychometric</option>
                <option>Waste Management</option>
                <option>Renewable Energy &amp; CO2</option>
                <option>Corporate Sustainability &amp; ESG</option>
                <option>Health Safety Environment</option>
              </select>
            </div>
            <div>
              <label class="psr-lbl">Degree <span class="o">(optional)</span></label>
              <input type="text" name="degree" class="psr-inp" placeholder="e.g. Master (S2), PhD">
            </div>
            <div>
              <label class="psr-lbl">University <span class="r">*</span></label>
              <input type="text" name="university" class="psr-inp" required placeholder="e.g. Stanford University">
            </div>
            <div>
              <label class="psr-lbl">Country <span class="r">*</span></label>
              <input type="text" name="country" class="psr-inp" required placeholder="e.g. United States">
            </div>
            <div>
              <label class="psr-lbl">QS World Rank <span class="o">(optional)</span></label>
              <input type="number" name="qs_rank" class="psr-inp" placeholder="e.g. 50" min="1">
            </div>
            <div>
              <label class="psr-lbl">Website <span class="o">(optional)</span></label>
              <input type="url" name="website" class="psr-inp" placeholder="https://...">
            </div>
            <div class="w2">
              <label class="psr-lbl">Description <span class="o">(optional)</span></label>
              <textarea name="description" class="psr-ta" rows="3" placeholder="Brief description of the program..."></textarea>
            </div>
          </div>
        </div>

        {{-- 2. Study Details --}}
        <div class="psr-card">
          <div class="psr-card-title">🎓 Study Details</div>
          <div class="psr-grid">
            <div>
              <label class="psr-lbl">Study Type <span class="o">(optional)</span></label>
              <select name="study_type" class="psr-sel">
                <option value="">-- Select --</option>
                <option>Full-time</option><option>Part-time</option>
                <option>Online</option><option>Blended</option>
                <option>Coursework</option><option>Research</option><option>Mixed</option>
              </select>
            </div>
            <div>
              <label class="psr-lbl">Study Duration <span class="o">(optional)</span></label>
              <input type="text" name="study_duration" class="psr-inp" placeholder="e.g. 2 years">
            </div>
            <div>
              <label class="psr-lbl">GPA Requirement <span class="o">(optional)</span></label>
              <input type="text" name="gpa" class="psr-inp" placeholder="e.g. 3.0 / 4.0">
            </div>
            <div>
              <label class="psr-lbl">Intake / Batch <span class="o">(optional)</span></label>
              <input type="text" name="intake" class="psr-inp" placeholder="e.g. September 2025">
            </div>
          </div>
        </div>

        {{-- 3. Language & Tests --}}
        <div class="psr-card">
          <div class="psr-card-title">🌐 Language & Tests</div>
          <div class="psr-grid">
            <div class="w2">
              <label class="psr-lbl">English Test <span class="o">(select all that apply)</span></label>
              <div class="psr-pills">
                @foreach(['IELTS','TOEFL iBT','TOEFL ITP','Duolingo','PTE','TOEIC'] as $t)
                <label class="psr-pill"><input type="checkbox" name="english_test[]" value="{{ $t }}"><span>{{ $t }}</span></label>
                @endforeach
              </div>
            </div>
            <div>
              <label class="psr-lbl">Other Language Test <span class="o">(optional)</span></label>
              <input type="text" name="other_language" class="psr-inp" placeholder="e.g. JLPT N2, DELF B2">
            </div>
            <div>
              <label class="psr-lbl">Standardized Test <span class="o">(optional)</span></label>
              <input type="text" name="standardized_test" class="psr-inp" placeholder="e.g. GRE, GMAT">
            </div>
            <div class="w2" style="display:flex;align-items:center;">
              <label class="psr-pill" style="border-radius:9px;background:#fef2f2;border-color:#fca5a5;">
                <input type="checkbox" name="req_standardized_test" value="1">
                <span style="color:#7f1d1d;">Standardized test is required</span>
              </label>
            </div>
            <div class="w2">
              <label class="psr-lbl">Other Notes <span class="o">(optional)</span></label>
              <textarea name="other" class="psr-ta" rows="2" placeholder="Any other requirements..."></textarea>
            </div>
          </div>
        </div>

        {{-- 4. Timeline --}}
        <div class="psr-card">
          <div class="psr-card-title">📅 Registration Timeline</div>
          <div class="psr-grid">
            <div>
              <label class="psr-lbl">Registration Open <span class="o">(optional)</span></label>
              <input type="date" name="open_date" class="psr-inp">
            </div>
            <div>
              <label class="psr-lbl">Application Deadline <span class="o">(optional)</span></label>
              <input type="date" name="deadline" class="psr-inp">
            </div>
            <div>
              <label class="psr-lbl">Screening Date <span class="o">(optional)</span></label>
              <input type="date" name="screening_date" class="psr-inp">
            </div>
            <div>
              <label class="psr-lbl">Written Test Date <span class="o">(optional)</span></label>
              <input type="date" name="written_test_date" class="psr-inp">
            </div>
            <div>
              <label class="psr-lbl">Interview Date <span class="o">(optional)</span></label>
              <input type="date" name="interview_date" class="psr-inp">
            </div>
            <div>
              <label class="psr-lbl">Shortlist Date <span class="o">(optional)</span></label>
              <input type="date" name="shortlist_date" class="psr-inp">
            </div>
          </div>
        </div>

        {{-- 5. Process & Requirements --}}
        <div class="psr-card">
          <div class="psr-card-title">📋 Process & Requirements</div>
          <div class="psr-grid">
            <div class="w2">
              <label class="psr-lbl">Registration Process & Selection <span class="o">(optional)</span></label>
              <textarea name="registration_process" class="psr-ta" rows="3" placeholder="Describe the registration steps and selection process..."></textarea>
            </div>
            <div class="w2">
              <label class="psr-lbl">Document Requirements <span class="o">(optional)</span></label>
              <textarea name="requirements" class="psr-ta" rows="3" placeholder="List all required documents and eligibility criteria..."></textarea>
            </div>
          </div>
        </div>

      </form>
    </div>{{-- /.psr-bd --}}

    {{-- Footer --}}
    <div class="psr-ft">
      <span style="font-size:11.5px;color:#9ca3af;"><span style="color:#dc2626;">*</span> Required fields</span>
      <div style="display:flex;gap:10px;">
        <button type="button" class="psr-btn psr-btn-cancel" onclick="psrClose()">Cancel</button>
        <button type="submit" form="psrForm" class="psr-btn psr-btn-submit">
          <i class="bi bi-send-fill"></i> Submit Request
        </button>
      </div>
    </div>

  </div>
</div>

{{-- Toast --}}
<div id="psr-toast">✅ Program Study submitted! Pending admin approval.</div>

<script>
// ── open / close ──────────────────────────────────
function psrOpen() {
    document.getElementById('psr-overlay').classList.add('psr-open');
    document.body.style.overflow = 'hidden';
}
function psrClose() {
    document.getElementById('psr-overlay').classList.remove('psr-open');
    document.body.style.overflow = '';
}
function psrCloseOnBackdrop(e) {
    if (e.target === document.getElementById('psr-overlay')) psrClose();
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') psrClose();
});

// ── wire all trigger links ────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // support old Bootstrap modal targets + new data-psr-open
    const triggers = document.querySelectorAll(
        '[data-bs-target="#psr-modal"], [data-bs-target="#modalSuggestProgram"], [data-psr-open]'
    );
    triggers.forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            // close any open Bootstrap modal first
            const openBsModal = document.querySelector('.modal.show');
            if (openBsModal && typeof bootstrap !== 'undefined') {
                bootstrap.Modal.getInstance(openBsModal)?.hide();
            }
            // Reset to Create mode
            const form = document.getElementById('psrForm');
            const title = document.getElementById('psrTitle');
            if (form) {
                form.reset();
                form.action = "{{ route('program-study-request.store') }}";
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            }
            if (title) {
                title.innerHTML = '🏛 Suggest New Program Study';
            }

            psrOpen();
        });
    });
});
</script>
