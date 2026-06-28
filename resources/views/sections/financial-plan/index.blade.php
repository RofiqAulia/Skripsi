@php
    $categories = [
        'arrival'   => ['title' => 'Arrival Cost',     'icon' => 'bi-airplane-fill'],
        'education' => ['title' => 'Education Cost',   'icon' => 'bi-book-fill'],
        'living'    => ['title' => 'Living Cost',       'icon' => 'bi-house-fill'],
        'family'    => ['title' => 'Family Support',   'icon' => 'bi-people-fill'],
    ];
    $groupedItems = $plan->items->groupBy('category');
    $isLocked = in_array($plan->status, ['submitted', 'under_review', 'approved']);

    // Hero stats
    $totalCost    = $plan->total_estimated_cost + 0;
    $totalFunding = $plan->total_funding + 0;
    $fundingGap   = $plan->funding_gap + 0;
@endphp

<section class="fp-section">

    {{-- ══════ HERO BANNER ══════ --}}
    <div class="fp-hero">
        <div class="fp-hero-orb fp-hero-orb-1"></div>
        <div class="fp-hero-orb fp-hero-orb-2"></div>
        <div class="fp-hero-inner">
            <div class="fp-hero-text">
                <span class="fp-hero-eyebrow">
                    <i class="bi bi-wallet2"></i> Financial Planning Module
                </span>
                <h1>Financial Plan</h1>
                <p>Plan and evaluate your finances for studying abroad with ease and clarity.</p>
            </div>
            <div class="fp-hero-right">
                <div class="fp-hero-stats">
                    <div class="fp-hero-stat">
                        <span class="stat-val" id="heroTotalCost">{{ number_format($totalCost, 0) }}</span>
                        <span class="stat-lbl">Est. Cost</span>
                    </div>
                    <div style="width:1px; background:rgba(255,255,255,0.2); height:40px; align-self:center;"></div>
                    <div class="fp-hero-stat">
                        <span class="stat-val" id="heroTotalFund">{{ number_format($totalFunding, 0) }}</span>
                        <span class="stat-lbl">Funded</span>
                    </div>
                    <div style="width:1px; background:rgba(255,255,255,0.2); height:40px; align-self:center;"></div>
                    <div class="fp-hero-stat">
                        <span class="stat-val" id="heroGap" style="color:{{ $fundingGap >= 0 ? '#6ee7b7' : '#fca5a5' }}">
                            {{ ($fundingGap >= 0 ? '+' : '') . number_format($fundingGap, 0) }}
                        </span>
                        <span class="stat-lbl">Funding Gap</span>
                    </div>
                </div>
                <span class="fp-badge status-{{ $plan->status }} ms-2">
                    <i class="bi bi-circle-fill" style="font-size:0.55rem;"></i>
                    {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ══════ JOURNEY STRIP ══════ --}}
    <div class="fp-journey-strip">
        <div class="fp-journey">
            <div class="journey-step {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'completed' : 'active' }}">
                <div class="j-icon"><i class="bi {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'bi-check' : 'bi-hourglass-split' }}"></i></div>
                <span>Scholarship</span>
            </div>
            <div class="journey-line {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'completed' : '' }}"></div>
            <div class="journey-step {{ in_array($plan->status, ['submitted', 'under_review', 'approved']) ? 'completed' : ($plan->scholarshipApplication->display_status === 'lolos' ? 'active' : '') }}">
                <div class="j-icon"><i class="bi {{ in_array($plan->status, ['submitted', 'under_review', 'approved']) ? 'bi-check' : 'bi-wallet2' }}"></i></div>
                <span>Financial Plan</span>
            </div>
            <div class="journey-line {{ $plan->status == 'approved' ? 'completed' : '' }}"></div>
            <div class="journey-step {{ $plan->status == 'approved' ? 'completed' : '' }}">
                <div class="j-icon"><i class="bi {{ $plan->status == 'approved' ? 'bi-check' : 'bi-file-earmark-check' }}"></i></div>
                <span>Doc Validation</span>
            </div>
        </div>
    </div>

    {{-- ══════ ALERTS ══════ --}}
    <div class="fp-container">
        <div style="padding-top: 1.5rem;">
            @if(session('success'))
                <div class="fp-alert fp-alert-success">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            @if($plan->status === 'revision_needed' && $plan->admin_notes)
                <div class="fp-alert" style="background:#fffbeb; border:1px solid #fde68a; color:#b45309; display:block; padding:1.25rem 1.5rem; border-radius:12px;">
                    <div class="d-flex align-items-center gap-2 mb-2" style="font-weight:700; font-size:1rem;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Revision Required
                    </div>
                    <div style="font-size:0.9rem; line-height:1.6; color:#78350f;">
                        {!! nl2br(e($plan->admin_notes)) !!}
                    </div>
                </div>
            @endif

            {{-- Status banners --}}
            @if(in_array($plan->status, ['submitted', 'under_review']))
                <div class="fp-alert" style="background:#dbeafe; border:1px solid #93c5fd; color:#1e40af; display:flex; align-items:center; gap:0.75rem; padding:1rem 1.5rem; border-radius:12px;">
                    <i class="bi bi-hourglass-split" style="font-size:1.3rem;"></i>
                    <div><strong>Financial Plan Submitted</strong><br>
                    <span style="font-size:0.9rem;">Your plan is currently under review. You may still upload reference files while waiting.</span></div>
                </div>
            @elseif($plan->status === 'approved')
                <div class="fp-alert" style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; display:flex; align-items:center; gap:0.75rem; padding:1rem 1.5rem; border-radius:12px;">
                    <i class="bi bi-check-circle-fill" style="font-size:1.3rem;"></i>
                    <div><strong>Financial Plan Approved!</strong><br>
                    <span style="font-size:0.9rem;">Your financial plan has been approved by the admin.</span></div>
                </div>
            @endif
        </div>

        {{-- ══════ MAIN GRID ══════ --}}
        <div class="fp-grid">

            {{-- ─── LEFT COL: Details & Form ─── --}}
            <div class="fp-main-col">

                <form id="financialPlanForm" action="{{ route('financial-plan.save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    {{-- PROFILE INFO (chips, read-only) --}}
                    <div class="fp-card">
                        <div class="fp-card-header">
                            <h5><i class="bi bi-person-badge"></i> Profile Information</h5>
                        </div>
                        <div class="fp-card-body">
                            <div class="fp-profile-grid">
                                <div class="fp-info-chip">
                                    <label>Name</label>
                                    <span>{{ auth()->user()->name }}</span>
                                </div>
                                <div class="fp-info-chip">
                                    <label>Email</label>
                                    <span>{{ auth()->user()->email }}</span>
                                </div>
                                <div class="fp-info-chip">
                                    <label>Institution</label>
                                    <span>{{ auth()->user()->company ?? '—' }}</span>
                                </div>
                                <div class="fp-info-chip">
                                    <label>Position</label>
                                    <span>{{ auth()->user()->position ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STUDY DETAILS --}}
                    <div class="fp-card">
                        <div class="fp-card-header">
                            <h5><i class="bi bi-mortarboard"></i> Study Details</h5>
                        </div>
                        <div class="fp-card-body">
                            {{-- Target scholarship selector --}}
                            <div class="fp-form-group mb-3">
                                <label>Target Scholarship</label>
                                <select class="fp-scholarship-select" onchange="window.location.href='?app_id=' + this.value">
                                    @foreach($allApplications as $app)
                                        <option value="{{ $app->id }}" {{ $plan->scholarship_application_id == $app->id ? 'selected' : '' }}>
                                            {{ $app->programStudy->scholarship ?? 'Scholarship' }} — {{ $app->programStudy->name }} ({{ $app->display_status_label }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fp-form-grid">
                                <div class="fp-form-group">
                                    <label>Country Destination</label>
                                    <input type="text" name="country_destination" class="fp-input" readonly
                                        value="{{ $plan->scholarshipApplication->programStudy->country ?? '' }}"
                                        style="background:#f8fafc; cursor:not-allowed;">
                                </div>
                                <div class="fp-form-group">
                                    <label>University Name</label>
                                    <input type="text" name="university_name" class="fp-input" readonly
                                        value="{{ $plan->scholarshipApplication->programStudy->university ?? '' }}"
                                        style="background:#f8fafc; cursor:not-allowed;">
                                </div>
                                <div class="fp-form-group">
                                    <label>Study Duration (Months)</label>
                                    @php
                                        $durStr = $plan->scholarshipApplication->programStudy->study_duration;
                                        $durMonths = 12;
                                        if ($durStr) {
                                            $val = intval($durStr);
                                            if ($val > 0) {
                                                $durMonths = str_contains(strtolower($durStr), 'month') ? $val : ($val <= 6 ? $val * 12 : $val);
                                            }
                                        }
                                    @endphp
                                    <input type="number" name="study_duration_month" class="fp-input" readonly
                                        value="{{ $durMonths }}" style="background:#f8fafc; cursor:not-allowed;">
                                </div>
                                <div class="fp-form-group">
                                    <label>Currency</label>
                                    <select name="currency" class="fp-input" {{ $isLocked ? 'disabled' : '' }}>
                                        @foreach(['IDR'=>'IDR – Indonesian Rupiah','USD'=>'USD – US Dollar','EUR'=>'EUR – Euro','GBP'=>'GBP – British Pound','AUD'=>'AUD – Australian Dollar'] as $code => $label)
                                            <option value="{{ $code }}" {{ $plan->currency == $code ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FINANCIAL CATEGORIES (tabbed) --}}
                    <div class="fp-card">
                        <div class="fp-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1"><i class="bi bi-list-check"></i> Financial Categories</h5>
                                <small class="text-muted" style="font-size:0.78rem;">Click a tab to switch category · Fill estimated costs</small>
                            </div>
                            @if(!$isLocked)
                            <div class="d-flex gap-2">
                                <a href="{{ route('financial-plan.export-excel', $plan->id) }}"
                                   class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                                   style="font-weight:600; border-radius:7px; font-size:0.8rem;">
                                    <i class="bi bi-file-earmark-excel"></i> Export
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-success d-flex align-items-center gap-1"
                                    style="font-weight:600; border-radius:7px; font-size:0.8rem;"
                                    onclick="document.getElementById('import_excel_file').click()">
                                    <i class="bi bi-upload"></i> Import
                                </button>
                                <input type="file" id="import_excel_file" class="d-none"
                                    accept=".xlsx, .xls" onchange="uploadExcelFile()">
                            </div>
                            @endif
                        </div>

                        {{-- Category Tabs --}}
                        <div class="fp-cat-tabs" role="tablist">
                            @foreach($categories as $key => $catData)
                            @php $itemCount = isset($groupedItems[$key]) ? $groupedItems[$key]->count() : 0; @endphp
                            <button type="button"
                                class="fp-cat-tab {{ $loop->first ? 'active' : '' }}"
                                onclick="switchTab('{{ $key }}')"
                                id="tab-{{ $key }}">
                                <i class="bi {{ $catData['icon'] }}"></i>
                                {{ $catData['title'] }}
                                <span class="cat-count">{{ $itemCount }}</span>
                            </button>
                            @endforeach
                        </div>

                        {{-- Category Panels --}}
                        @foreach($categories as $key => $catData)
                        <div class="fp-cat-panel {{ $loop->first ? 'active' : '' }}" id="panel-{{ $key }}">
                            <div class="fp-table-wrap">
                                <table class="fp-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th style="width:17%">Est. Cost</th>
                                            <th style="width:17%">Scholarship</th>
                                            <th style="width:13%">Gap</th>
                                            <th style="width:18%">Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($groupedItems[$key]))
                                            @foreach($groupedItems[$key] as $item)
                                            @php
                                                $costVal  = ($item->created_at == $item->updated_at && !$isLocked) ? '' : ($item->estimated_cost + 0);
                                                $scholVal = ($item->created_at == $item->updated_at && !$isLocked) ? '' : ($item->scholarship_coverage + 0);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                        name="items[{{ $item->id }}][estimated_cost]"
                                                        class="fp-input-sm calc-item-cost"
                                                        value="{{ $costVal }}"
                                                        data-id="{{ $item->id }}"
                                                        placeholder="0"
                                                        {{ $isLocked ? 'readonly' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                        name="items[{{ $item->id }}][scholarship_coverage]"
                                                        class="fp-input-sm calc-item-schol"
                                                        value="{{ $scholVal }}"
                                                        data-id="{{ $item->id }}"
                                                        placeholder="0"
                                                        {{ $isLocked ? 'readonly' : '' }}>
                                                </td>
                                                <td>
                                                    <span class="gap-amount {{ $item->gap_amount >= 0 ? 'text-success' : 'text-danger' }}"
                                                        id="gap_{{ $item->id }}">
                                                        {{ ($item->gap_amount >= 0 ? '+' : '') . number_format($item->gap_amount + 0, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="file" id="file_item_{{ $item->id }}" class="d-none"
                                                        onchange="uploadItemFile({{ $item->id }})"
                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                    <div id="item_ref_container_{{ $item->id }}">
                                                        @if($item->reference_file_path)
                                                            @php
                                                                $ext = strtolower(pathinfo($item->reference_file_name, PATHINFO_EXTENSION));
                                                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                                            @endphp
                                                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                                                <a href="{{ asset($item->reference_file_path) }}" target="_blank"
                                                                   class="fp-ref-file-link" title="{{ $item->reference_file_name }}">
                                                                    <i class="bi {{ $isImage ? 'bi-file-earmark-image text-success' : 'bi-file-earmark-pdf text-danger' }}"></i>
                                                                    <span>{{ Str::limit($item->reference_file_name, 12) }}</span>
                                                                </a>
                                                                @if(!in_array($plan->status, ['approved']))
                                                                    <button type="button" class="btn-icon text-warning p-0 border-0 bg-transparent"
                                                                        onclick="document.getElementById('file_item_{{ $item->id }}').click()"
                                                                        style="width:22px;height:22px;font-size:0.78rem;">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </button>
                                                                    <button type="button" class="btn-icon text-danger p-0 border-0 bg-transparent"
                                                                        onclick="deleteItemFile({{ $item->id }})"
                                                                        style="width:22px;height:22px;font-size:0.78rem;">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <button type="button" class="fp-upload-ref-btn"
                                                                onclick="document.getElementById('file_item_{{ $item->id }}').click()">
                                                                <i class="bi bi-cloud-arrow-up"></i>
                                                                <span>Upload</span>
                                                                <small>PDF / Image</small>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div id="item_ref_status_{{ $item->id }}" class="text-muted mt-1"
                                                        style="display:none; font-size:0.7rem">
                                                        <i class="spinner-border spinner-border-sm"></i> Uploading...
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="5" class="text-center text-muted py-3">No items</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {{-- Category subtotal --}}
                            @if(isset($groupedItems[$key]))
                            @php
                                $catCost  = $groupedItems[$key]->sum('estimated_cost');
                                $catSchol = $groupedItems[$key]->sum('scholarship_coverage');
                                $catGap   = $catCost - $catSchol;
                            @endphp
                            <div class="fp-cat-footer">
                                <span>Total Est. Cost <strong id="catCost-{{ $key }}">{{ number_format($catCost, 2) }}</strong></span>
                                <span>Scholarship <strong id="catSchol-{{ $key }}">{{ number_format($catSchol, 2) }}</strong></span>
                                <span class="{{ $catGap >= 0 ? 'text-success' : 'text-danger' }}">
                                    Gap <strong id="catGap-{{ $key }}">{{ ($catGap >= 0 ? '+' : '') . number_format($catGap, 2) }}</strong>
                                </span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- SAVE BUTTON --}}
                    @if(!$isLocked)
                    <div class="fp-actions-bar">
                        <div class="fp-actions-left">
                            <button type="submit" class="fp-btn-save">
                                <i class="bi bi-save"></i> Save Draft
                            </button>
                        </div>
                        <small class="text-muted" style="font-size:0.78rem;">
                            <i class="bi bi-info-circle me-1"></i>Save before submitting
                        </small>
                    </div>
                    @endif

                </form>

                {{-- SUBMIT --}}
                @if(!$isLocked)
                <div class="fp-submit-area text-end">
                    <form id="financialPlanSubmitForm" action="{{ route('financial-plan.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit" class="fp-btn-submit-main">
                            Submit Financial Plan <i class="bi bi-send-check"></i>
                        </button>
                    </form>
                </div>
                @endif

            </div>

            {{-- ─── RIGHT COL: Summary ─── --}}
            <div class="fp-side-col">

                {{-- SUMMARY CARD --}}
                <div class="fp-card summary-card" style="margin-top:0;">
                    <div class="fp-card-header">
                        <h5><i class="bi bi-calculator"></i> Summary</h5>
                    </div>
                    <div class="fp-card-body">
                        <div class="summary-item">
                            <span>Total Estimated Cost</span>
                            <strong id="displayTotalCost">{{ number_format($plan->total_estimated_cost + 0, 2) }}</strong>
                        </div>
                        <div class="summary-item">
                            <span>Total Funding</span>
                            <strong id="displayTotalFunding" class="text-success">{{ number_format($plan->total_funding + 0, 2) }}</strong>
                        </div>
                        <div class="summary-item gap-item">
                            <span>Funding Gap</span>
                            <strong id="displayFundingGap" class="{{ $plan->funding_gap >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ ($plan->funding_gap >= 0 ? '+' : '') . number_format($plan->funding_gap + 0, 2) }}
                            </strong>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENT UPLOAD --}}
                <div class="fp-card">
                    <div class="fp-card-header">
                        <h5><i class="bi bi-paperclip"></i> Supporting Documents</h5>
                    </div>
                    <div class="fp-card-body" id="fp-doc-list">
                        @if($plan->documents->isEmpty())
                            <div class="fp-upload-area" id="fpDropZone"
                                ondragover="event.preventDefault(); this.style.borderColor='#c0392b'"
                                ondragleave="this.style.borderColor=''"
                                ondrop="handleDocDrop(event)">
                                <i class="bi bi-cloud-upload" style="font-size:2rem; color:#cbd5e1;"></i>
                                <p class="mt-2 mb-1" style="font-weight:600; color:#475569; font-size:0.9rem;">Drag & drop or click to upload</p>
                                <p class="text-muted" style="font-size:0.78rem;">PDF, JPG, PNG up to 10 MB</p>
                                <label class="btn btn-sm mt-2"
                                    style="background:var(--fp-primary); color:#fff; border-radius:7px; cursor:pointer; font-size:0.82rem; padding:0.4rem 1rem;">
                                    <i class="bi bi-folder2-open me-1"></i> Browse File
                                    <input type="file" class="d-none" id="fpDocInput"
                                        accept=".pdf,.jpg,.jpeg,.png" multiple
                                        onchange="uploadFpDoc(this.files)">
                                </label>
                            </div>
                        @else
                            @foreach($plan->documents as $doc)
                            @php
                                $ext2 = strtolower(pathinfo($doc->original_name ?? $doc->file_path, PATHINFO_EXTENSION));
                                $isImg2 = in_array($ext2, ['jpg','jpeg','png','gif','webp']);
                            @endphp
                            <div class="fp-doc-item" id="fp-doc-{{ $doc->id }}">
                                <div class="doc-icon">
                                    <i class="bi {{ $isImg2 ? 'bi-file-earmark-image' : 'bi-file-earmark-pdf' }}"></i>
                                </div>
                                <div class="doc-info">
                                    <h6>{{ Str::limit($doc->original_name ?? basename($doc->file_path), 22) }}</h6>
                                    <span>{{ strtoupper($ext2) }} • <span class="fp-badge-sm status-{{ $doc->status }}">{{ ucfirst($doc->status) }}</span></span>
                                </div>
                                <div class="doc-actions">
                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn-icon" title="View">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                    @if(!in_array($plan->status, ['approved']))
                                    <form method="POST" action="{{ route('financial-plan.document.destroy', $doc->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon" title="Delete"
                                            onclick="return confirm('Delete this file?')">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @if(!in_array($plan->status, ['approved']))
                            <label class="btn btn-sm w-100 mt-2"
                                style="background:#f8fafc; border:1.5px dashed #cbd5e1; color:#64748b; border-radius:8px; cursor:pointer; font-size:0.82rem; font-weight:600;">
                                <i class="bi bi-plus-circle me-1"></i> Add More Files
                                <input type="file" class="d-none" accept=".pdf,.jpg,.jpeg,.png" multiple
                                    onchange="uploadFpDoc(this.files)">
                            </label>
                            @endif
                        @endif
                        <div id="fp-doc-upload-status" style="display:none; font-size:0.8rem; color:#64748b; margin-top:0.5rem; text-align:center;">
                            <i class="spinner-border spinner-border-sm"></i> Uploading...
                        </div>
                    </div>
                </div>

            </div>

        </div>{{-- /fp-grid --}}
    </div>{{-- /fp-container --}}

</section>

@include('sections.financial-plan.styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sections.financial-plan.scripts')

<script>
// ── Tab switching ──
function switchTab(key) {
    document.querySelectorAll('.fp-cat-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.fp-cat-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + key).classList.add('active');
    document.getElementById('panel-' + key).classList.add('active');
}

// ── Update hero stats when inputs change ──
function updateHeroStats() {
    const totalCostEl = document.getElementById('heroTotalCost');
    const totalFundEl = document.getElementById('heroTotalFund');
    const gapEl       = document.getElementById('heroGap');
    const dispCost    = document.getElementById('displayTotalCost');
    const dispFund    = document.getElementById('displayTotalFunding');
    const dispGap     = document.getElementById('displayFundingGap');

    let cost = 0, fund = 0;
    document.querySelectorAll('.calc-item-cost').forEach(el => cost += parseFloat(el.value) || 0);
    document.querySelectorAll('.calc-item-schol').forEach(el => fund += parseFloat(el.value) || 0);
    const gap = fund - cost;

    const fmt = (n) => new Intl.NumberFormat().format(Math.abs(Math.round(n)));
    const fmtFull = (n) => new Intl.NumberFormat(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}).format(n);

    if (totalCostEl) totalCostEl.textContent = fmt(cost);
    if (totalFundEl) totalFundEl.textContent = fmt(fund);
    if (gapEl) {
        gapEl.textContent = (gap >= 0 ? '+' : '-') + fmt(gap);
        gapEl.style.color = gap >= 0 ? '#6ee7b7' : '#fca5a5';
    }
    if (dispCost) dispCost.textContent = fmtFull(cost);
    if (dispFund) dispFund.textContent = fmtFull(fund);
    if (dispGap) {
        dispGap.textContent = (gap >= 0 ? '+' : '') + fmtFull(gap);
        dispGap.className = gap >= 0 ? 'text-success' : 'text-danger';
    }
}

document.querySelectorAll('.calc-item-cost, .calc-item-schol').forEach(input => {
    input.addEventListener('input', updateHeroStats);
});
</script>
