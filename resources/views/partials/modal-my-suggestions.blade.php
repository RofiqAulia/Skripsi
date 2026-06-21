{{-- ================================================================
     CUSTOM OVERLAY: My Suggested Programs
================================================================ --}}

<style>
/* ── Overlay backdrop ── */
#mysugg-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0,0,0,0.55);
    align-items: center;
    justify-content: center;
    padding: 20px;
}
#mysugg-overlay.mysugg-open {
    display: flex;
    animation: mysuggFadeIn .2s ease;
}
@keyframes mysuggFadeIn { from { opacity:0 } to { opacity:1 } }

/* ── Dialog box ── */
#mysugg-dialog {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 700px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.25);
    animation: mysuggSlideUp .25s ease;
}
@keyframes mysuggSlideUp { from { transform:translateY(30px);opacity:0 } to { transform:translateY(0);opacity:1 } }

/* ── Header ── */
#mysugg-dialog .mysugg-hd {
    background: linear-gradient(135deg, #1f2937, #374151);
    padding: 20px 26px;
    flex-shrink: 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    border-radius: 18px 18px 0 0;
}
#mysugg-dialog .mysugg-hd h5 { color:#fff; font-weight:700; font-size:17px; margin:0; }
#mysugg-dialog .mysugg-hd p  { color:rgba(255,255,255,.75); font-size:12px; margin:4px 0 0; }
.mysugg-close-btn {
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
.mysugg-close-btn:hover { background: rgba(255,255,255,.35); }

/* ── Body ── */
#mysugg-dialog .mysugg-bd {
    flex: 1 1 auto;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
    padding: 22px 24px;
    background: #f4f6f9;
}

/* ── Footer ── */
#mysugg-dialog .mysugg-ft {
    flex-shrink: 0;
    padding: 14px 24px;
    background: #fff;
    border-top: 1px solid #e8eaf0;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    border-radius: 0 0 18px 18px;
}

/* ── Card ── */
.mysugg-card {
    background: #fff;
    border-radius: 13px;
    padding: 16px 20px;
    margin-bottom: 12px;
    border: 1px solid #eaedf0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.mysugg-card:last-child { margin-bottom: 0; }
.mysugg-title {
    font-weight: 700;
    color: #1f2937;
    font-size: 15px;
}
.mysugg-univ {
    font-size: 13px;
    color: #4b5563;
}
.mysugg-status {
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 50px;
    display: inline-flex;
    width: fit-content;
    text-transform: uppercase;
}
.status-pending { background: #f3f4f6; color: #4b5563; }
.status-approved { background: #dcfce7; color: #166534; }
.status-revision { background: #fef08a; color: #854d0e; }
.status-rejected { background: #fee2e2; color: #991b1b; }

.mysugg-notes {
    margin-top: 8px;
    background: #fffbeb;
    border-left: 3px solid #f59e0b;
    padding: 10px 14px;
    font-size: 12.5px;
    color: #78350f;
    border-radius: 0 6px 6px 0;
}
.mysugg-notes.rejected {
    background: #fef2f2;
    border-left-color: #ef4444;
    color: #7f1d1d;
}

.mysugg-empty {
    text-align: center;
    color: #6b7280;
    padding: 40px 20px;
    font-size: 14px;
}
</style>

{{-- ── OVERLAY ─────────────────────────────────────────── --}}
<div id="mysugg-overlay" onclick="mysuggCloseOnBackdrop(event)">
  <div id="mysugg-dialog" role="dialog" aria-modal="true" aria-labelledby="mysuggTitle">

    {{-- Header --}}
    <div class="mysugg-hd">
      <div>
        <h5 id="mysuggTitle"><i class="bi bi-clock-history me-2"></i>My Suggested Programs</h5>
        <p>Track the status of the program studies you have submitted.</p>
      </div>
      <button class="mysugg-close-btn" onclick="mysuggClose()" aria-label="Close">✕</button>
    </div>

    {{-- Scrollable body --}}
    <div class="mysugg-bd">
        @if(isset($mySuggestions) && $mySuggestions->count() > 0)
            @foreach($mySuggestions as $sugg)
            <div class="mysugg-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="mysugg-title">{{ $sugg->name }}</div>
                        <div class="mysugg-univ">{{ $sugg->university }} - {{ $sugg->country }}</div>
                        <div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">
                            Submitted on {{ $sugg->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div>
                        <span class="mysugg-status status-{{ $sugg->status }}">
                            {{ $sugg->status }}
                        </span>
                        @if(in_array($sugg->status, ['pending', 'revision']))
                        <button class="btn btn-sm btn-outline-primary ms-2" style="border-radius:20px; font-size:11px; padding:2px 8px;" onclick="editSuggestion({{ $sugg->id }}, {{ json_encode($sugg) }})">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        @endif
                    </div>
                </div>

                @if(in_array($sugg->status, ['revision', 'rejected']) && $sugg->admin_notes)
                <div class="mysugg-notes {{ $sugg->status === 'rejected' ? 'rejected' : '' }}">
                    <strong>Admin Notes:</strong><br>
                    {!! nl2br(e($sugg->admin_notes)) !!}
                </div>
                @endif
            </div>
            @endforeach
        @else
            <div class="mysugg-empty">
                <i class="bi bi-inbox fs-1 mb-3 d-block" style="opacity: 0.5;"></i>
                You haven't suggested any programs yet.
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="mysugg-ft">
        <button type="button" class="psr-btn psr-btn-cancel" onclick="mysuggClose()">Close</button>
    </div>

  </div>
</div>

<script>
function mysuggOpen() {
    document.getElementById('mysugg-overlay').classList.add('mysugg-open');
    document.body.style.overflow = 'hidden';
}
function mysuggClose() {
    document.getElementById('mysugg-overlay').classList.remove('mysugg-open');
    document.body.style.overflow = '';
}
function mysuggCloseOnBackdrop(e) {
    if (e.target === document.getElementById('mysugg-overlay')) mysuggClose();
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') mysuggClose();
});
function editSuggestion(id, data) {
    // 1. Close current modal
    mysuggClose();

    // 2. Open the Suggestion form
    const form = document.getElementById('psrForm');
    const title = document.getElementById('psrTitle');
    
    // Change Title
    title.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Edit Program Study';

    // Change action URL & add _method=PUT
    form.action = `/program-study-request/${id}`;
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    }

    // Reset all fields first
    form.reset();

    // Populate fields
    for (const key in data) {
        const input = form.querySelector(`[name="${key}"]`);
        if (input && input.type !== 'checkbox' && input.type !== 'radio') {
            input.value = data[key] || '';
        }
    }

    // Populate checkboxes (English Test & req_standardized_test)
    if (data.english_test && Array.isArray(data.english_test)) {
        data.english_test.forEach(test => {
            const cb = form.querySelector(`input[name="english_test[]"][value="${test}"]`);
            if (cb) cb.checked = true;
        });
    }
    if (data.req_standardized_test) {
        const cb = form.querySelector(`input[name="req_standardized_test"]`);
        if (cb) cb.checked = true;
    }

    // Open Modal
    if (typeof psrOpen === 'function') {
        psrOpen();
    }
}
</script>
