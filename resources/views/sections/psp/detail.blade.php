{{-- ============================
     SCHOLARSHIP DETAIL PAGE
============================= --}}

<style>
/* ======= HERO ======= */
.detail-hero {
    background: linear-gradient(135deg, #8b0000 0%, #1a1a1a 100%);
    color: #fff;
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}
.detail-hero::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 60px;
    background: #f8f9fa;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.detail-hero-badge {
    display: inline-flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.hero-badge-item {
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.4px;
}
.badge-country { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
.badge-funding  { background: #fff; color: #8b0000; }
.badge-open     { background: #22c55e; color: #fff; }
.badge-closed   { background: #ef4444; color: #fff; }

.detail-hero h1 {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 14px;
}
.detail-hero .meta-row {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
    margin-top: 24px;
}
.meta-item small { font-size: 12px; color: rgba(255,255,255,0.6); display: block; }
.meta-item strong { font-size: 16px; }

/* ======= CONTENT ======= */
.detail-content {
    padding: 60px 0;
    background: #f8f9fa;
}
.detail-card {
    background: #fff;
    border-radius: 20px;
    padding: 36px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    margin-bottom: 24px;
}
.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #8b0000;
    border-left: 4px solid #8b0000;
    padding-left: 14px;
    margin-bottom: 24px;
}
.req-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}
.req-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 16px 18px;
}
.req-item label {
    font-size: 11px;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 4px;
}
.req-item span {
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

/* Test / Doc List */
.tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 6px;
}
.tag-item {
    background: #f3f4f6;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 13px;
    color: #374151;
}
.tag-item span {
    font-weight: 600;
    color: #8b0000;
    margin-left: 6px;
}

/* Benefit list */
.benefit-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.benefit-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
    color: #374151;
    background: #f0fdf4;
    border-radius: 12px;
    padding: 12px 16px;
}
.benefit-list li::before {
    content: '✓';
    background: #22c55e;
    color: #fff;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

/* CTA */
.cta-bar {
    background: #fff;
    border-radius: 20px;
    padding: 30px 36px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
}
.cta-bar h3 { font-size: 20px; font-weight: 700; margin: 0; }
.cta-bar p  { color: #6b7280; margin: 4px 0 0; }
.btn-pilih {
    background: #8b0000;
    color: #fff;
    border-radius: 999px;
    padding: 14px 32px;
    font-weight: 600;
    text-decoration: none;
    font-size: 15px;
    transition: 0.2s;
    white-space: nowrap;
}
.btn-pilih:hover { background: #a50000; color: #fff; }
.btn-back {
    color: #8b0000;
    text-decoration: none;
    font-size: 14px;
}
.btn-back:hover { text-decoration: underline; }

@media(max-width: 768px){
    .detail-hero h1 { font-size: 28px; }
    .cta-bar { flex-direction: column; }
}
</style>

{{-- ===== HERO ===== --}}
<section class="detail-hero">
    <div class="container-lg">

        <!-- BACK -->
        <div class="mb-4">
            <a href="{{ route('psp') }}" class="btn-back">← Back to PSP</a>
        </div>

        <!-- BADGES -->
        <div class="detail-hero-badge">
            @if($scholarship->country)
                <span class="hero-badge-item badge-country">{{ $scholarship->country }}</span>
            @endif
            @if($scholarship->funding_type)
                <span class="hero-badge-item badge-funding">{{ $scholarship->funding_type }}</span>
            @endif
            @php
                $isOpen = !$scholarship->deadline || \Carbon\Carbon::now()->isBefore($scholarship->deadline);
            @endphp
            <span class="hero-badge-item {{ $isOpen ? 'badge-open' : 'badge-closed' }}">
                {{ $isOpen ? 'OPEN' : 'CLOSED' }}
            </span>
        </div>

        <h1>{{ $scholarship->title }}</h1>

        @if($scholarship->description)
            <p style="color:rgba(255,255,255,0.8); max-width:600px; font-size:16px;">
                {{ $scholarship->description }}
            </p>
        @endif

        <div class="meta-row">
            @if($scholarship->open_date)
                <div class="meta-item">
                    <small>Open Date</small>
                    <strong>{{ $scholarship->open_date->format('d M Y') }}</strong>
                </div>
            @endif
            @if($scholarship->deadline)
                <div class="meta-item">
                    <small>Deadline</small>
                    <strong>{{ $scholarship->deadline->format('d M Y') }}</strong>
                </div>
            @endif
            @if($scholarship->programStudy)
                <div class="meta-item">
                    <small>Program Study</small>
                    <strong>{{ $scholarship->programStudy->name }}</strong>
                </div>
            @endif
        </div>

    </div>
</section>

{{-- ===== CONTENT ===== --}}
<section class="detail-content">
    <div class="container-lg">

        {{-- === REQUIREMENTS === --}}
        <div class="detail-card">
            <div class="section-title">Requirements</div>

            <div class="req-grid">
                @if($scholarship->age)
                    <div class="req-item">
                        <label>Max Age</label>
                        <span>{{ $scholarship->age }} Years</span>
                    </div>
                @endif
                @if($scholarship->gpa)
                    <div class="req-item">
                        <label>Minimum GPA</label>
                        <span>{{ $scholarship->gpa }}</span>
                    </div>
                @endif
                @if($scholarship->nationality)
                    <div class="req-item">
                        <label>Nationality</label>
                        <span>{{ $scholarship->nationality }}</span>
                    </div>
                @endif
                @if($scholarship->other_language)
                    <div class="req-item">
                        <label>Other Language</label>
                        <span>{{ $scholarship->other_language }}</span>
                    </div>
                @endif
                @if($scholarship->standardized_test)
                    <div class="req-item">
                        <label>Standardized Test</label>
                        <span>{{ $scholarship->standardized_test }}</span>
                    </div>
                @endif
            </div>

            {{-- English Tests --}}
            @if($scholarship->english_test && count($scholarship->english_test) > 0)
                <div class="mt-4">
                    <label style="font-size:13px; color:#6b7280; font-weight:600;">English Proficiency Tests</label>
                    <div class="tag-list">
                        @foreach($scholarship->english_test as $test)
                            <div class="tag-item">
                                {{ $test['test_name'] ?? '-' }}
                                <span>Min. {{ $test['minimum_score'] ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Documents --}}
            @if($scholarship->document && count($scholarship->document) > 0)
                <div class="mt-4">
                    <label style="font-size:13px; color:#6b7280; font-weight:600;">Required Documents</label>
                    <div class="tag-list">
                        @foreach($scholarship->document as $doc)
                            <div class="tag-item">📄 {{ $doc['document_name'] ?? '-' }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Other Notes --}}
            @if($scholarship->other)
                <div class="mt-4">
                    <label style="font-size:13px; color:#6b7280; font-weight:600;">Other Notes</label>
                    <p style="color:#374151; margin-top:6px;">{{ $scholarship->other }}</p>
                </div>
            @endif
        </div>

        {{-- === BENEFITS === --}}
        @if($scholarship->benefit && count($scholarship->benefit) > 0)
        <div class="detail-card">
            <div class="section-title">Benefits</div>
            <ul class="benefit-list">
                @foreach($scholarship->benefit as $b)
                    <li>{{ $b['benefit_detail'] ?? '-' }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- === PROGRAM STUDY INFO === --}}
        @if($scholarship->programStudy)
        <div class="detail-card">
            <div class="section-title">Program Study</div>
            <div class="req-grid">
                <div class="req-item">
                    <label>Program Name</label>
                    <span>{{ $scholarship->programStudy->name }}</span>
                </div>
                @if($scholarship->programStudy->degree)
                <div class="req-item">
                    <label>Degree</label>
                    <span>{{ $scholarship->programStudy->degree }}</span>
                </div>
                @endif
                <div class="req-item">
                    <label>University</label>
                    <span>{{ $scholarship->programStudy->university }}</span>
                </div>
                <div class="req-item">
                    <label>Country</label>
                    <span>{{ $scholarship->programStudy->country }}</span>
                </div>
                @if($scholarship->programStudy->website)
                <div class="req-item">
                    <label>Website</label>
                    <span>
                        <a href="{{ $scholarship->programStudy->website }}" target="_blank" style="color:#8b0000;">
                            Visit →
                        </a>
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- === CTA BAR === --}}
        <div class="cta-bar">
            <div>
                <h3>Interested in this scholarship?</h3>
                <p>Click "Choose This Scholarship" to select it and proceed with your research topic.</p>
            </div>
            <a href="{{ route('psp') }}#submit-study-plan" class="btn-pilih" onclick="localStorage.setItem('psp_from_detail', '{{ $scholarship->id }}')">
                Choose This Scholarship
            </a>
        </div>

    </div>
</section>
