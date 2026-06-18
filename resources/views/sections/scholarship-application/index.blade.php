<section class="sa-section">
<div class="container-lg sa-container">

    {{-- HEADER --}}
    <div class="sa-header">
        <div>
            <h1><i class="bi bi-mortarboard-fill"></i> <span data-lang-key="nav-financial-plan">Financial Plan</span></h1>
            <p>Record and track your scholarship application progress</p>
        </div>
        <button class="sa-btn-add" data-bs-toggle="modal" data-bs-target="#modalAddScholarship">
            <i class="bi bi-plus-lg"></i> Add Scholarship
        </button>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="sa-alert sa-alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if($errors->has('duplicate'))
        <div class="sa-alert sa-alert-error"><i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first('duplicate') }}</div>
    @endif

    {{-- STAT CARDS --}}
    <div class="sa-stats">
        <div class="sa-stat-card">
            <div class="sa-stat-icon bg-blue"><i class="bi bi-collection-fill"></i></div>
            <div><span>Total</span><h3>{{ $statsTotal }}</h3></div>
        </div>
        <div class="sa-stat-card">
            <div class="sa-stat-icon bg-green"><i class="bi bi-trophy-fill"></i></div>
            <div><span>Accepted</span><h3>{{ $statsLolos }}</h3></div>
        </div>
        <div class="sa-stat-card">
            <div class="sa-stat-icon bg-amber"><i class="bi bi-hourglass-split"></i></div>
            <div><span>Pending</span><h3>{{ $statsPending }}</h3></div>
        </div>
        <div class="sa-stat-card">
            <div class="sa-stat-icon bg-red"><i class="bi bi-x-circle-fill"></i></div>
            <div><span>Rejected</span><h3>{{ $statsTidakLolos }}</h3></div>
        </div>
    </div>

    {{-- APPLICATION LIST --}}
    @if($applications->isEmpty())
        <div class="sa-empty">
            <i class="bi bi-journal-x"></i>
            <p>No scholarship application data yet.</p>
        </div>
    @else
        <div class="sa-list">
            @foreach($applications as $app)
            <div class="sa-card {{ $app->display_status }}">
                {{-- Card Header --}}
                <div class="sa-card-header">
                    <div class="sa-card-title">
                        <span class="sa-badge status-{{ $app->display_status }}">
                            @if($app->display_status === 'lolos') <i class="bi bi-trophy-fill"></i>
                            @elseif($app->display_status === 'tidak_lolos') <i class="bi bi-x-circle-fill"></i>
                            @else <i class="bi bi-hourglass-split"></i> @endif
                            {{ $app->display_status_label }}
                        </span>
                        <h4>{{ $app->programStudy->scholarship ?? 'Scholarship' }}</h4>
                        <div class="sa-card-meta">
                            <span><i class="bi bi-globe"></i> {{ $app->programStudy->country ?? '—' }}</span>
                            <span><i class="bi bi-book"></i> {{ $app->programStudy->name }}</span>
                            @if($app->university)
                                <span><i class="bi bi-building"></i> {{ $app->university }}</span>
                            @endif
                            @if($app->pspApplication)
                                <span class="sa-psp-badge"><i class="bi bi-link-45deg"></i> PSP Connected</span>
                            @endif
                        </div>
                    </div>
                    <div class="sa-card-actions">
                        <button class="sa-btn-expand" onclick="toggleHistory({{ $app->id }})">
                            <i class="bi bi-pencil-square"></i> Update Status / History
                        </button>
                        <form method="POST" action="{{ route('scholarship-application.destroy', $app->id) }}"
                            onsubmit="return confirm('Delete this data?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="sa-btn-del" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>

                {{-- Financial Plan CTA (If Accepted) --}}
                @if($app->status === 'lolos')
                <div class="sa-success-cta">
                    <div class="sa-success-icon">🎉</div>
                    <div class="sa-success-content">
                        <h5>Congratulations!</h5>
                        <p>You have been accepted for a scholarship. Complete the Financial Plan to continue the Study Preparation process.</p>
                    </div>
                    <a href="{{ route('financial-plan.index', ['app_id' => $app->id]) }}" class="sa-btn-continue-fp">
                        Continue Financial Plan <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endif

                {{-- History Log (accordion) --}}
                <div class="sa-history" id="history-{{ $app->id }}" style="display:none">
                    <h6><i class="bi bi-clock-history"></i> Stage History</h6>
                    <div class="sa-timeline">
                        @foreach($app->logs as $log)
                        <div class="sa-timeline-item {{ $loop->last ? 'last' : '' }}">
                            <div class="sa-tl-dot status-dot-{{ $log->status }}"></div>
                            <div class="sa-tl-body">
                                <div class="sa-tl-header d-flex align-items-center flex-wrap gap-2">
                                    <strong>{{ $log->stage_label }}</strong>
                                    <span class="sa-badge-sm status-{{ $log->status }}">{{ $log->status_label }}</span>
                                    <span class="sa-tl-date">{{ $log->log_date->format('d M Y') }}</span>
                                    <button type="button" class="sa-btn-edit-log" onclick="toggleEditLog({{ $log->id }})" title="Update status & notes">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                                
                                {{-- Display Mode --}}
                                <div id="display-log-{{ $log->id }}">
                                    @if($log->notes)
                                        <p class="sa-tl-notes">{{ $log->notes }}</p>
                                    @endif
                                </div>

                                {{-- Inline Form Edit Mode --}}
                                <form id="form-log-{{ $log->id }}" method="POST" action="{{ route('scholarship-application.updateLog', $log->id) }}" style="display: none;" class="sa-edit-log-form mt-2">
                                    @csrf
                                    <div class="row g-2 align-items-center">
                                        <div class="col-sm-4">
                                            <select name="status" class="sa-select-sm" required>
                                                @foreach(\App\Models\ScholarshipApplication::STATUSES as $key => $label)
                                                    <option value="{{ $key }}" {{ $log->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="notes" class="sa-input-sm" placeholder="Notes/reasons..." value="{{ $log->notes }}">
                                        </div>
                                        <div class="col-sm-3 d-flex gap-1 justify-content-end">
                                            <button type="submit" class="sa-btn-save-sm w-50" title="Save"><i class="bi bi-check-lg"></i></button>
                                            <button type="button" class="sa-btn-cancel-sm w-50" onclick="toggleEditLog({{ $log->id }})" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

{{-- ═══════════════════════════════════════ --}}
{{-- MODAL: Tambah Beasiswa Baru --}}
{{-- ═══════════════════════════════════════ --}}
<div class="modal fade" id="modalAddScholarship" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content sa-modal">
            <div class="modal-header sa-modal-header">
                <h5><i class="bi bi-mortarboard-fill"></i> Add Scholarship Application</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('scholarship-application.store') }}">
                @csrf
                <div class="modal-body">
                    @if($errors->any() && !$errors->has('duplicate'))
                        <div class="sa-alert sa-alert-error mb-3">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="sa-form-grid">
                        {{-- Program Studi dengan Search --}}
                        <div class="sa-form-group full">
                            <label>Study Program <span class="req">*</span></label>
                            <div class="sa-search-dropdown-wrapper">
                                <input type="text" id="inputSearchProdi" class="sa-input" placeholder="🔍 Search Study Program (e.g. MIT, LPDP, Operations...)" autocomplete="off" required value="">
                                <div class="sa-dropdown-results" id="prodiDropdownResults" style="display: none;">
                                    @foreach($programStudies as $p)
                                        <div class="sa-dropdown-item" 
                                            data-id="{{ $p->id }}"
                                            data-name="{{ $p->name }}"
                                            data-university="{{ $p->university }}"
                                            data-scholarship="{{ $p->scholarship }}"
                                            data-country="{{ $p->country }}">
                                            <strong>{{ $p->name }}</strong>
                                            <span>{{ $p->university }} — {{ $p->scholarship }}</span>
                                        </div>
                                    @endforeach
                                    <div class="sa-no-results" id="prodiNoResults" style="display: none;">No matching study program found.</div>
                                </div>
                            </div>
                            <input type="hidden" name="program_study_id" id="hiddenProdiId" required value="{{ old('program_study_id') }}">
                        </div>

                        {{-- Beasiswa (auto-fill, read-only) --}}
                        <div class="sa-form-group">
                            <label>Scholarship</label>
                            <input type="text" id="autoScholarship" class="sa-input" readonly placeholder="Auto-fill from Study Program" value="">
                        </div>

                        {{-- Negara (auto-fill, read-only) --}}
                        <div class="sa-form-group">
                            <label>Destination Country</label>
                            <input type="text" id="autoCountry" class="sa-input" readonly placeholder="Auto-fill from Study Program" value="">
                        </div>

                        {{-- Universitas (auto-filled, tapi bisa diedit) --}}
                        <div class="sa-form-group full">
                            <label>University <span class="req">*</span></label>
                            <input type="text" name="university" id="autoUniversity" class="sa-input" placeholder="Auto-fill from Study Program" required value="{{ old('university') }}">
                        </div>

                        <input type="hidden" name="stage" value="pendaftaran">

                        {{-- Status --}}
                        <div class="sa-form-group">
                            <label>Status <span class="req">*</span></label>
                            <select name="status" required class="sa-select">
                                <option value="">-- Select Status --</option>
                                @foreach(\App\Models\ScholarshipApplication::STATUSES as $key => $label)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div class="sa-form-group">
                            <label>Update Date <span class="req">*</span></label>
                            <input type="date" name="updated_date" required class="sa-input" value="{{ old('updated_date', date('Y-m-d')) }}">
                        </div>

                        {{-- Catatan --}}
                        <div class="sa-form-group full">
                            <label>Notes <span class="opt">(optional)</span></label>
                            <textarea name="notes" class="sa-textarea" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer sa-modal-footer">
                    <button type="button" class="sa-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="sa-btn-submit"><i class="bi bi-check-lg"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



@include('sections.scholarship-application.styles')

<script>
// Searchable Program Study Dropdown & Auto-fill
const inputSearchProdi = document.getElementById('inputSearchProdi');
const prodiDropdownResults = document.getElementById('prodiDropdownResults');
const hiddenProdiId = document.getElementById('hiddenProdiId');
const autoScholarship = document.getElementById('autoScholarship');
const autoCountry = document.getElementById('autoCountry');
const autoUniversity = document.getElementById('autoUniversity');
const prodiNoResults = document.getElementById('prodiNoResults');
const prodiItems = document.querySelectorAll('.sa-dropdown-item');

if (inputSearchProdi) {
    // Show results on focus
    inputSearchProdi.addEventListener('focus', () => {
        prodiDropdownResults.style.display = 'block';
    });

    // Filter results on input
    inputSearchProdi.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        let hasMatch = false;

        prodiItems.forEach(item => {
            const name = item.dataset.name.toLowerCase();
            const university = item.dataset.university.toLowerCase();
            const scholarship = item.dataset.scholarship.toLowerCase();

            if (name.includes(query) || university.includes(query) || scholarship.includes(query)) {
                item.style.display = 'block';
                hasMatch = true;
            } else {
                item.style.display = 'none';
            }
        });

        prodiNoResults.style.display = hasMatch ? 'none' : 'block';
        prodiDropdownResults.style.display = 'block';
        
        // Clear selection if input is cleared
        if (query === '') {
            hiddenProdiId.value = '';
            autoScholarship.value = '';
            autoCountry.value = '';
            autoUniversity.value = '';
        }
    });

    // Handle item selection
    prodiItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const id = item.dataset.id;
            const name = item.dataset.name;
            const university = item.dataset.university;
            const scholarship = item.dataset.scholarship;
            const country = item.dataset.country;

            // Set inputs
            hiddenProdiId.value = id;
            inputSearchProdi.value = `${name} (${university})`;
            autoScholarship.value = scholarship || '';
            autoCountry.value = country || '';
            autoUniversity.value = university || '';

            // Hide results
            prodiDropdownResults.style.display = 'none';
        });
    });

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.sa-search-dropdown-wrapper')) {
            prodiDropdownResults.style.display = 'none';
        }
    });
}

// Toggle history accordion
function toggleHistory(id) {
    const el = document.getElementById('history-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

// Toggle edit mode for history logs
function toggleEditLog(id) {
    const displayEl = document.getElementById('display-log-' + id);
    const formEl = document.getElementById('form-log-' + id);
    
    if (formEl.style.display === 'none') {
        formEl.style.display = 'block';
        displayEl.style.display = 'none';
    } else {
        formEl.style.display = 'none';
        displayEl.style.display = 'block';
    }
}



// Buka modal jika ada error validasi (supaya error tetap tampil)
@if($errors->any() && !$errors->has('duplicate'))
    const modalEl = document.getElementById('modalAddScholarship');
    if (modalEl) { new bootstrap.Modal(modalEl).show(); }
@endif
</script>

</section>
