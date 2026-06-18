@extends('layouts.app')

@section('content')

<div class="insights-page">

    {{-- ═══ HERO ═══ --}}
    <div class="insights-hero">
        <div class="container-lg">
            <span class="eyebrow">Knowledge Hub</span>
            <h1 class="hero-title">Scholarship Insights</h1>
            <p class="hero-sub">
                Articles, guides, tips, and opportunities — everything you need to plan your scholarship journey.
            </p>

            {{-- CATEGORY FILTER --}}
            <div class="filter-pills">
                <a href="{{ route('insights.index') }}"
                   class="pill {{ is_null($category) ? 'active' : '' }}">All</a>
                @foreach($categories as $key => $label)
                    <a href="{{ route('insights.index', ['category' => $key]) }}"
                       class="pill {{ $category === $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ GRID ═══ --}}
    <div class="container-lg insights-grid-section">

        @if($insights->isEmpty())
            <div class="empty-state">
                <i class="bi bi-newspaper"></i>
                <h4>No articles found</h4>
                <p>Try a different category or check back soon.</p>
                <a href="{{ route('insights.index') }}" class="btn-back">View All</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($insights as $article)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('insights.show', $article->slug) }}" class="insight-card-link">
                        <article class="insight-card">

                            {{-- COVER --}}
                            <div class="insight-cover">
                                @if($article->cover_image)
                                    <img src="{{ asset('storage/' . $article->cover_image) }}"
                                         alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('images/scholarships-.jpeg') }}"
                                         alt="{{ $article->title }}">
                                @endif
                                <span class="insight-badge">{{ $article->category_label }}</span>
                            </div>

                            {{-- BODY --}}
                            <div class="insight-body">
                                <div class="insight-meta">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $article->published_at->format('d M Y') }}
                                    @if($article->author)
                                        &nbsp;·&nbsp;
                                        <i class="bi bi-person"></i>
                                        {{ $article->author->name }}
                                    @endif
                                </div>
                                <h3 class="insight-title">{{ $article->title }}</h3>
                                <p class="insight-excerpt">{{ Str::limit($article->excerpt, 120) }}</p>
                                <span class="read-more-link">
                                    Read Article <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>

                        </article>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrapper mt-5">
                {{ $insights->links() }}
            </div>
        @endif

    </div>

</div>

<style>
/* ─── PAGE WRAPPER ─── */
.insights-page {
    background: #f8f9fb;
    min-height: 100vh;
    padding-bottom: 80px;
}

/* ─── HERO ─── */
.insights-hero {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    padding: 80px 0 60px;
    text-align: center;
}

.eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.7);
    margin-bottom: 12px;
}

.insights-hero .hero-title {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 12px;
}

.insights-hero .hero-sub {
    font-size: 16px;
    color: rgba(255,255,255,0.8);
    max-width: 560px;
    margin: 0 auto 32px;
}

/* ─── FILTER PILLS ─── */
.filter-pills {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.pill {
    padding: 7px 18px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    color: rgba(255,255,255,0.8);
    border: 1.5px solid rgba(255,255,255,0.3);
    transition: all 0.2s;
}

.pill:hover {
    background: rgba(255,255,255,0.15);
    color: #fff;
}

.pill.active {
    background: #fff;
    color: #8b0000;
    border-color: #fff;
    font-weight: 600;
}

/* ─── GRID ─── */
.insights-grid-section {
    padding-top: 56px;
}

/* ─── CARD ─── */
.insight-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.insight-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.insight-card-link:hover .insight-card {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}

/* ─── COVER ─── */
.insight-cover {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.insight-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.insight-card-link:hover .insight-cover img {
    transform: scale(1.05);
}

.insight-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: #8b0000;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 50px;
}

/* ─── BODY ─── */
.insight-body {
    padding: 20px 22px 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.insight-meta {
    font-size: 12px;
    color: #9ca3af;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
}

.insight-meta i {
    font-size: 12px;
}

.insight-title {
    font-size: 17px;
    font-weight: 700;
    color: #111;
    line-height: 1.4;
    margin-bottom: 10px;
}

.insight-excerpt {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    flex: 1;
    margin-bottom: 16px;
}

.read-more-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #8b0000;
}

.insight-card-link:hover .read-more-link i {
    transform: translateX(4px);
    transition: transform 0.2s;
}

.read-more-link i {
    transition: transform 0.2s;
}

/* ─── EMPTY STATE ─── */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #9ca3af;
}

.empty-state i {
    font-size: 56px;
    display: block;
    margin-bottom: 16px;
}

.empty-state h4 {
    font-size: 20px;
    color: #374151;
    margin-bottom: 8px;
}

.btn-back {
    display: inline-block;
    margin-top: 16px;
    padding: 10px 24px;
    background: #8b0000;
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
}

/* ─── PAGINATION ─── */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    gap: 6px;
}

.pagination-wrapper .page-link {
    border-radius: 8px !important;
    color: #8b0000;
    border-color: #e5e7eb;
    padding: 8px 14px;
}

.pagination-wrapper .page-item.active .page-link {
    background: #8b0000;
    border-color: #8b0000;
    color: #fff;
}

@media (max-width: 768px) {
    .insights-hero .hero-title { font-size: 28px; }
    .insights-grid-section { padding-top: 36px; }
}
</style>

@endsection
