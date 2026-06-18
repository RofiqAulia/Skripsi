<section class="fp-section">
<div class="container-lg fp-container">
    {{-- HEADER --}}
    <div class="fp-header">
        <div>
            <h1><i class="bi bi-wallet2"></i> Financial Readiness</h1>
            <p>Plan and evaluate your financial readiness for studying abroad.</p>
        </div>
        <div class="fp-header-status">
            <span class="fp-badge status-{{ $plan->status }}">{{ ucfirst(str_replace('_', ' ', $plan->status)) }}</span>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="fp-alert fp-alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    @if($plan->status === 'revision_needed' && $plan->admin_notes)
        <div class="fp-alert" style="background: #fffbeb; border: 1px solid #fde68a; color: #b45309; display: block; padding: 1.25rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
            <div class="d-flex align-items-center gap-2 mb-2" style="font-weight: 700; font-size: 1.05rem;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.2rem;"></i>
                Revisi Diperlukan / Revision Required
            </div>
            <div style="font-size: 0.95rem; line-height: 1.5; color: #78350f; font-weight: 500;">
                {!! nl2br(e($plan->admin_notes)) !!}
            </div>
        </div>
    @endif
    
    {{-- PROGRESS / PREPARATION JOURNEY --}}
    <div class="fp-journey">
        <div class="journey-step {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'completed' : 'active' }}">
            <div class="j-icon"><i class="bi {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'bi-check' : 'bi-hourglass-split' }}"></i></div>
            <span>{{ $plan->scholarshipApplication->display_status === 'lolos' ? 'Scholarship Accepted' : 'Scholarship Process' }}</span>
        </div>
        <div class="journey-line {{ $plan->scholarshipApplication->display_status === 'lolos' ? 'completed' : '' }}"></div>
        <div class="journey-step {{ in_array($plan->status, ['submitted', 'under_review', 'approved']) ? 'completed' : ($plan->scholarshipApplication->display_status === 'lolos' ? 'active' : '') }}">
            <div class="j-icon"><i class="bi {{ in_array($plan->status, ['submitted', 'under_review', 'approved']) ? 'bi-check' : 'bi-wallet2' }}"></i></div>
            <span>Financial Plan</span>
        </div>
        <div class="journey-line {{ $plan->status == 'approved' ? 'completed' : '' }}"></div>
        <div class="journey-step {{ $plan->status == 'approved' ? 'active' : '' }}">
            <div class="j-icon"><i class="bi bi-file-earmark-check"></i></div>
            <span>Document Validation</span>
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <div class="fp-grid">
        
        {{-- LEFT COLUMN: Details & Form --}}
        <div class="fp-main-col">
            
            <form id="financialPlanForm" action="{{ route('financial-plan.save') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                
                {{-- STUDY DETAILS --}}
                <div class="fp-card">
                    <div class="fp-card-header">
                        <h5><i class="bi bi-mortarboard"></i> Study Details</h5>
                    </div>
                    <div class="fp-card-body fp-form-grid">
                        <div class="fp-form-group fp-full-width" style="grid-column: span 2;">
                            <label>Target Scholarship</label>
                            <select class="fp-select" onchange="window.location.href='?app_id=' + this.value" style="background-color: #fff; font-weight: 600; border-color: #3b82f6;">
                                @foreach($allApplications as $app)
                                    <option value="{{ $app->id }}" {{ $plan->scholarship_application_id == $app->id ? 'selected' : '' }}>
                                        {{ $app->programStudy->scholarship ?? 'Scholarship' }} — {{ $app->programStudy->name }} (Status: {{ $app->display_status_label }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fp-form-group">
                            <label>Country Destination</label>
                            <input type="text" name="country_destination" class="fp-input" readonly value="{{ $plan->scholarshipApplication->programStudy->country ?? '' }}" style="background-color: #f3f4f6; cursor: not-allowed;">
                        </div>
                        <div class="fp-form-group">
                            <label>University Name</label>
                            <input type="text" name="university_name" class="fp-input" readonly value="{{ $plan->scholarshipApplication->programStudy->university ?? '' }}" style="background-color: #f3f4f6; cursor: not-allowed;">
                        </div>
                        <div class="fp-form-group">
                            <label>Study Duration (Months)</label>
                            @php
                                $durStr = $plan->scholarshipApplication->programStudy->study_duration;
                                $durMonths = 12;
                                if ($durStr) {
                                    $val = intval($durStr);
                                    if ($val > 0) {
                                        if (str_contains(strtolower($durStr), 'month')) {
                                            $durMonths = $val;
                                        } else {
                                            $durMonths = $val <= 6 ? $val * 12 : $val;
                                        }
                                    }
                                }
                            @endphp
                            <input type="number" name="study_duration_month" class="fp-input" readonly value="{{ $durMonths }}" style="background-color: #f3f4f6; cursor: not-allowed;">
                        </div>
                        <div class="fp-form-group">
                            <label>Currency Used</label>
                            <select name="currency" class="fp-select">
                                <option value="IDR" {{ $plan->currency == 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                                <option value="USD" {{ $plan->currency == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ $plan->currency == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ $plan->currency == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="AUD" {{ $plan->currency == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- COST CATEGORIES ACCORDION --}}
                <div class="fp-card">
                    <div class="fp-card-header d-flex justify-content-between align-items-center">
                        <h5><i class="bi bi-list-check"></i> Financial Categories</h5>
                        <small class="text-muted">Fill in your estimated costs below</small>
                    </div>
                    <div class="fp-card-body p-0">
                        <div class="fp-categories-list">
                            @php
                                $groupedItems = $plan->items->groupBy('category');
                                $categories = [
                                    'arrival' => ['title' => 'Arrival Cost', 'icon' => 'bi-airplane'],
                                    'education' => ['title' => 'Education Cost', 'icon' => 'bi-book'],
                                    'living' => ['title' => 'Living Cost', 'icon' => 'bi-house'],
                                    'family' => ['title' => 'Family Support', 'icon' => 'bi-people']
                                ];
                            @endphp
                            
                            @foreach($categories as $key => $catData)
                            <div class="fp-category-block mb-4">
                                <h6 class="fp-category-title p-3 m-0 bg-light border-bottom d-flex align-items-center">
                                    <i class="bi {{ $catData['icon'] }} me-2 text-primary"></i> 
                                    <strong>{{ $catData['title'] }}</strong>
                                </h6>
                                <div class="fp-category-body p-0 border">
                                    <div class="table-responsive">
                                        <table class="fp-table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th style="width: 18%">Estimated Cost</th>
                                                    <th style="width: 18%">Scholarship Coverage</th>
                                                    <th style="width: 18%">Gap</th>
                                                    <th style="width: 22%">Reference Source</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($groupedItems[$key]))
                                                    @foreach($groupedItems[$key] as $item)
                                                    <tr>
                                                        <td class="fw-medium text-secondary">{{ $item->item_name }}</td>
                                                        <td><input type="number" step="0.01" name="items[{{ $item->id }}][estimated_cost]" class="fp-input-sm calc-item-cost" value="{{ $item->estimated_cost + 0 }}" data-id="{{ $item->id }}"></td>
                                                        <td><input type="number" step="0.01" name="items[{{ $item->id }}][scholarship_coverage]" class="fp-input-sm calc-item-schol" value="{{ $item->scholarship_coverage + 0 }}" data-id="{{ $item->id }}"></td>
                                                        <td><span class="gap-amount fw-bold {{ $item->gap_amount >= 0 ? 'text-success' : 'text-danger' }}" id="gap_{{ $item->id }}">{{ ($item->gap_amount >= 0 ? '+' : '') . number_format($item->gap_amount + 0, 2) }}</span></td>
                                                        <td>
                                                            <div id="item_ref_container_{{ $item->id }}" class="d-flex align-items-center gap-2">
                                                                <input type="file" id="file_item_{{ $item->id }}" class="d-none" onchange="uploadItemFile({{ $item->id }})" accept=".pdf,image/*">
                                                                @if($item->reference_file_path)
                                                                    <a href="{{ Storage::url($item->reference_file_path) }}" target="_blank" class="text-primary fw-medium" style="font-size: 0.8rem;" id="item_ref_link_{{ $item->id }}">
                                                                        <i class="bi bi-file-earmark-check"></i> {{ Str::limit($item->reference_file_name, 15) }}
                                                                    </a>
                                                                    @if(!in_array($plan->status, ['submitted', 'under_review', 'approved']))
                                                                        <button type="button" class="btn-icon text-warning p-0 border-0 bg-transparent" onclick="document.getElementById('file_item_{{ $item->id }}').click()" title="Edit Reference" style="font-size: 0.85rem;">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                        </button>
                                                                        <button type="button" class="btn-icon text-danger p-0 border-0 bg-transparent" onclick="deleteItemFile({{ $item->id }})" title="Delete Reference" style="font-size: 0.85rem;">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    @if(!in_array($plan->status, ['submitted', 'under_review', 'approved']))
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 d-flex align-items-center gap-1" onclick="document.getElementById('file_item_{{ $item->id }}').click()" style="font-size: 0.72rem; border-radius: 4px;">
                                                                            <i class="bi bi-upload"></i> Upload Source
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div id="item_ref_status_{{ $item->id }}" class="text-muted mt-1" style="display:none; font-size:0.7rem"><i class="spinner-border spinner-border-sm"></i> Uploading...</div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="5" class="text-center text-muted py-3">No items</td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if(!in_array($plan->status, ['submitted', 'under_review', 'approved']))
                <div class="fp-actions mt-4">
                    <button type="submit" class="fp-btn-save"><i class="bi bi-save"></i> Save Draft</button>
                </div>
                @endif
            </form>

            
            {{-- SUBMIT BUTTON --}}
            @if(!in_array($plan->status, ['submitted', 'under_review', 'approved']))
            <div class="fp-submit-area mt-4 mb-4 text-end">
                <form action="{{ route('financial-plan.submit') }}" method="POST" onsubmit="return confirm('Are you sure you want to submit this Financial Plan? Data cannot be changed after submission.')">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <button type="submit" class="fp-btn-submit-main">
                        Submit Financial Plan <i class="bi bi-send-check"></i>
                    </button>
                </form>
            </div>
            @endif

        </div>

        {{-- RIGHT COLUMN: Summary & Analytics --}}
        <div class="fp-side-col">
            
            {{-- READINESS SCORE --}}
            <div class="fp-card score-card">
                <div class="fp-card-body text-center">
                    <h5 class="text-muted mb-3">Financial Readiness</h5>
                    
                    <div class="readiness-circle">
                        <svg viewBox="0 0 36 36" class="circular-chart {{ $plan->risk_level == 'high' ? 'red' : ($plan->risk_level == 'medium' ? 'orange' : 'green') }}" id="readinessSvg">
                            <path class="circle-bg"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <path class="circle" id="readinessCirclePath"
                                stroke-dasharray="{{ $plan->readiness_percentage }}, 100"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <text x="18" y="20.35" class="percentage" id="displayReadiness">{{ $plan->readiness_percentage }}%</text>
                        </svg>
                    </div>
                    
                    <div class="risk-badge mt-3" id="displayRisk">
                        @if($plan->risk_level == 'high') <span class="fp-badge status-rejected"><i class="bi bi-exclamation-triangle"></i> High Risk</span>
                        @elseif($plan->risk_level == 'medium') <span class="fp-badge status-pending"><i class="bi bi-exclamation-circle"></i> Moderate Risk</span>
                        @else <span class="fp-badge status-approved"><i class="bi bi-shield-check"></i> Low Risk</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="fp-card summary-card mt-4">
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
                    <hr>
                    <div class="summary-item gap-item">
                        <span>Funding Gap</span>
                        <strong id="displayFundingGap" class="{{ $plan->funding_gap > 0 ? 'text-danger' : 'text-success' }}">{{ number_format($plan->funding_gap + 0, 2) }}</strong>
                    </div>
                </div>
            </div>

            {{-- RISK DETECTION WARNINGS --}}
            <div class="fp-card mt-4" id="riskWarnings" style="display: {{ $plan->readiness_percentage < 100 ? 'block' : 'none' }}">
                <div class="fp-card-header bg-light border-0">
                    <h6 class="text-danger m-0"><i class="bi bi-shield-exclamation"></i> Risk Warnings</h6>
                </div>
                <div class="fp-card-body p-3">
                    <div class="warning-alert">
                        <i class="bi bi-info-circle text-danger"></i>
                        <p class="m-0 text-danger small">Funding gap detected. Make sure you have a plan to cover the shortage of funds before departure.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@include('sections.financial-plan.styles')
@include('sections.financial-plan.scripts')

</section>
