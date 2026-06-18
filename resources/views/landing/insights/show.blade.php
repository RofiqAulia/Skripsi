@extends('layouts.app')

@section('content')

<div class="insight-detail-page">

    {{-- ═══ HERO ─── --}}
    <div class="detail-hero" style="background-image: url('{{ $insight->cover_image ? asset('storage/' . $insight->cover_image) : asset('images/scholarships-.jpeg') }}')">
        <div class="detail-hero-overlay"></div>
        <div class="container-lg detail-hero-content">
            <a href="{{ route('insights.index') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> All Insights
            </a>
            <span class="detail-badge">{{ $insight->category_label }}</span>
            <h1 class="detail-title">{{ $insight->title }}</h1>
            <div class="detail-meta">
                <span><i class="bi bi-calendar3"></i> {{ $insight->published_at->format('d F Y') }}</span>
                @if($insight->author)
                    <span><i class="bi bi-person-circle"></i> {{ $insight->author->name }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ CONTENT ═══ --}}
    <div class="container-lg detail-layout">
        <div class="row g-5">

            {{-- LEFT: Article body --}}
            <div class="col-lg-8">
                <div class="article-card">

                    {{-- EXCERPT HIGHLIGHT --}}
                    <p class="article-excerpt">{{ $insight->excerpt }}</p>

                    {{-- BODY --}}
                    @if($insight->body)
                        <div class="article-body">
                            {!! $insight->body !!}
                        </div>
                    @else
                        <div class="article-body text-muted fst-italic">
                            Full article content coming soon.
                        </div>
                    @endif

                    {{-- EXTERNAL LINK --}}
                    @if($insight->source_url)
                        <div class="source-link-box mt-5">
                            <i class="bi bi-link-45deg"></i>
                            <div>
                                <strong>Official Source</strong>
                                <a href="{{ $insight->source_url }}" target="_blank" rel="noopener">
                                    {{ $insight->source_url }}
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- RIGHT: Sidebar --}}
            <div class="col-lg-4">

                {{-- APPLY CTA --}}
                <div class="sidebar-cta">
                    <h5>Ready to Start?</h5>
                    <p>Build your Personal Study Plan and get matched with a mentor who can guide your application.</p>
                    <a href="{{ auth()->check() ? route('psp') : route('login') }}" class="btn-cta-primary">
                        Create My Study Plan
                    </a>
                    <a href="{{ route('mentoring') }}" class="btn-cta-secondary">
                        Find a Mentor
                    </a>
                </div>

                {{-- RELATED ARTICLES --}}
                @if($related->count())
                <div class="sidebar-related mt-4">
                    <h6 class="related-title">More {{ $insight->category_label }}</h6>
                    @foreach($related as $rel)
                        <a href="{{ route('insights.show', $rel->slug) }}" class="related-item">
                            <div class="related-img">
                                <img src="{{ $rel->cover_image ? asset('storage/' . $rel->cover_image) : asset('images/scholarships-.jpeg') }}"
                                     alt="{{ $rel->title }}">
                            </div>
                            <div class="related-info">
                                <p class="related-item-title">{{ Str::limit($rel->title, 60) }}</p>
                                <small>{{ $rel->published_at->format('d M Y') }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif

                {{-- BACK LINK --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('insights.index') }}" class="all-insights-link">
                        <i class="bi bi-grid-3x3-gap"></i> Browse All Insights
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
/* ─── PAGE ─── */
.insight-detail-page {
    background: #f8f9fb;
    padding-bottom: 80px;
}

/* ─── HERO ─── */
.detail-hero {
    position: relative;
    min-height: 380px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    padding-bottom: 48px;
}

.detail-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(139,0,0,0.5) 50%, rgba(0,0,0,0.2) 100%);
}

.detail-hero-content {
    position: relative;
    z-index: 2;
    color: #fff;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 20px;
    transition: color 0.2s;
}

.back-link:hover { color: #fff; }

.detail-badge {
    display: inline-block;
    background: #8b0000;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 14px;
    border-radius: 50px;
    margin-bottom: 14px;
}

.detail-title {
    font-size: 36px;
    font-weight: 800;
    line-height: 1.3;
    margin-bottom: 16px;
    max-width: 780px;
}

.detail-meta {
    display: flex;
    gap: 20px;
    font-size: 14px;
    color: rgba(255,255,255,0.75);
    flex-wrap: wrap;
}

.detail-meta i { margin-right: 5px; }

/* ─── LAYOUT ─── */
.detail-layout {
    padding-top: 48px;
}

/* ─── ARTICLE CARD ─── */
.article-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
}

.article-excerpt {
    font-size: 18px;
    font-weight: 500;
    color: #374151;
    line-height: 1.7;
    border-left: 4px solid #8b0000;
    padding-left: 20px;
    margin-bottom: 32px;
    font-style: italic;
}

.article-body {
    font-size: 15px;
    color: #374151;
    line-height: 1.85;
}

.article-body h2 {
    font-size: 22px;
    font-weight: 700;
    color: #111;
    margin: 32px 0 12px;
}

.article-body h3 {
    font-size: 18px;
    font-weight: 600;
    color: #111;
    margin: 24px 0 10px;
}

.article-body ul, .article-body ol {
    padding-left: 24px;
    margin-bottom: 16px;
}

.article-body li { margin-bottom: 6px; }

.article-body a {
    color: #8b0000;
    text-decoration: underline;
}

.article-body blockquote {
    border-left: 4px solid #8b0000;
    padding: 12px 20px;
    background: rgba(139,0,0,0.04);
    border-radius: 0 8px 8px 0;
    margin: 20px 0;
    color: #4b5563;
    font-style: italic;
}

/* ─── SOURCE LINK BOX ─── */
.source-link-box {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 18px 20px;
}

.source-link-box i {
    font-size: 22px;
    color: #059669;
    margin-top: 2px;
    flex-shrink: 0;
}

.source-link-box strong {
    display: block;
    font-size: 13px;
    color: #374151;
    margin-bottom: 4px;
}

.source-link-box a {
    font-size: 14px;
    color: #059669;
    word-break: break-all;
}

/* ─── SIDEBAR CTA ─── */
.sidebar-cta {
    background: linear-gradient(135deg, #8b0000, #c40000);
    border-radius: 16px;
    padding: 28px 24px;
    color: #fff;
    text-align: center;
}

.sidebar-cta h5 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 10px;
}

.sidebar-cta p {
    font-size: 14px;
    color: rgba(255,255,255,0.85);
    margin-bottom: 20px;
    line-height: 1.5;
}

.btn-cta-primary {
    display: block;
    width: 100%;
    background: #fff;
    color: #8b0000;
    padding: 11px 20px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 10px;
    transition: 0.2s;
}

.btn-cta-primary:hover {
    background: #f3f3f3;
    color: #8b0000;
}

.btn-cta-secondary {
    display: block;
    width: 100%;
    border: 1.5px solid rgba(255,255,255,0.5);
    color: #fff;
    padding: 10px 20px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: 0.2s;
}

.btn-cta-secondary:hover {
    background: rgba(255,255,255,0.12);
    color: #fff;
}

/* ─── RELATED ─── */
.sidebar-related {
    background: #fff;
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
}

.related-title {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9ca3af;
    margin-bottom: 16px;
}

.related-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    text-decoration: none;
    color: inherit;
    transition: 0.2s;
}

.related-item:last-child { border-bottom: none; }

.related-item:hover { opacity: 0.75; }

.related-img {
    width: 64px;
    height: 56px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
}

.related-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-info { flex: 1; }

.related-item-title {
    font-size: 13px;
    font-weight: 600;
    color: #111;
    line-height: 1.4;
    margin-bottom: 4px;
}

.related-info small {
    font-size: 11px;
    color: #9ca3af;
}

/* ─── BACK LINK ─── */
.all-insights-link {
    font-size: 14px;
    color: #8b0000;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.all-insights-link:hover { text-decoration: underline; color: #8b0000; }

@media (max-width: 768px) {
    .detail-title { font-size: 24px; }
    .article-card { padding: 24px 18px; }
    .article-excerpt { font-size: 16px; }
}
</style>

@endsection
