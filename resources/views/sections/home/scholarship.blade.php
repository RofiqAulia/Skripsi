@php
    use App\Models\ScholarshipInsight;
    $articles = ScholarshipInsight::published()->limit(6)->get();
@endphp

<section class="scholarship-section">

    <div class="container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <span class="section-eyebrow" data-lang-key="scholarship-eyebrow">Latest Updates</span>
                <h2 class="scholarship-title" data-lang-key="scholarship-title">
                    Scholarship Insights
                </h2>
                <p class="scholarship-subtext" data-lang-key="scholarship-subtext">
                    Stay updated with the latest scholarship opportunities, tips, and guides to help you succeed.
                </p>
            </div>

            <!-- BUTTON → links to listing page -->
            <a href="{{ route('insights.index') }}" class="btn-all" data-lang-key="scholarship-btn-all">
                Explore All Insights →
            </a>
        </div>

        @if($articles->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="insight-empty">
                <i class="bi bi-newspaper"></i>
                <p data-lang-key="scholarship-empty">No scholarship insights published yet. Check back soon!</p>
            </div>
        @else
            <!-- WRAPPER -->
            <div class="position-relative">

                <!-- BUTTON LEFT -->
                <button class="scroll-btn left" onclick="scrollScholarship(-1)" aria-label="Scroll left">‹</button>

                <!-- BUTTON RIGHT -->
                <button class="scroll-btn right" onclick="scrollScholarship(1)" aria-label="Scroll right">›</button>

                <!-- SCROLL AREA -->
                <div class="scholarship-scroll" id="scholarshipScroll">

                    @foreach ($articles as $article)
                    <a href="{{ route('insights.show', $article->slug) }}" class="card-article-link">
                        <article class="card-article-horizontal">

                            <!-- TEXT -->
                            <div class="card-content">
                                <span class="tag">{{ $article->category_label }}</span>

                                <h5>{{ $article->title }}</h5>

                                <p>{{ Str::limit($article->excerpt, 100) }}</p>

                                <!-- DATE -->
                                <div class="card-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $article->published_at->format('d M Y') }}
                                </div>

                                <span class="read-more" data-lang-key="scholarship-read-more">
                                    Read Article →
                                </span>
                            </div>

                            <!-- IMAGE -->
                            <div class="card-image">
                                @if($article->cover_image)
                                    <img src="{{ asset($article->cover_image) }}"
                                         alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('images/scholarships-.jpeg') }}"
                                         alt="{{ $article->title }}">
                                @endif
                            </div>

                        </article>
                    </a>
                    @endforeach

                </div>

            </div>

            <!-- DOT INDICATORS -->
            <div class="scroll-dots mt-4" id="scrollDots">
                @foreach ($articles as $i => $article)
                    <span class="dot {{ $loop->first ? 'active' : '' }}" onclick="scrollToCard({{ $loop->index }})"></span>
                @endforeach
            </div>
        @endif

    </div>

    <!-- STYLE -->
    <style>
        .scholarship-section {
            background-color: #fff;
            padding: 100px 0 80px;
        }

        /* EYEBROW */
        .section-eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8b0000;
            margin-bottom: 8px;
        }

        .scholarship-title {
            color: #111;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .scholarship-subtext {
            color: #666;
            font-size: 15px;
        }

        /* BUTTON ALL */
        .btn-all {
            white-space: nowrap;
            background: linear-gradient(135deg, #8b0000, #c40000);
            color: #fff;
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.25s;
            flex-shrink: 0;
        }

        .btn-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139,0,0,0.25);
            color: #fff;
        }

        /* SCROLL AREA */
        .scholarship-scroll {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 12px 5px 20px;
            scrollbar-width: none;
        }

        .scholarship-scroll::-webkit-scrollbar {
            display: none;
        }

        /* CARD LINK WRAPPER */
        .card-article-link {
            display: block;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
        }

        /* CARD */
        .card-article-horizontal {
            min-width: 400px;
            max-width: 400px;
            background: linear-gradient(135deg, #8b0000, #c40000);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-article-link:hover .card-article-horizontal {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(139,0,0,0.25);
        }

        /* CONTENT */
        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .card-content h5 {
            font-weight: 600;
            font-size: 15px;
            color: #fff;
            margin: 4px 0 2px;
            line-height: 1.4;
        }

        .card-content p {
            font-size: 13px;
            color: rgba(255,255,255,0.8);
            line-height: 1.5;
            margin: 0 0 6px;
        }

        /* DATE */
        .card-date {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 4px;
        }

        .card-date i {
            font-size: 11px;
        }

        /* IMAGE */
        .card-image {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* TAG */
        .tag {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            width: fit-content;
        }

        /* READ MORE */
        .read-more {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 2px;
            transition: transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .card-article-link:hover .read-more {
            text-decoration: underline;
        }

        /* SCROLL BUTTONS */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            cursor: pointer;
            z-index: 10;
            font-size: 20px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b0000;
            transition: 0.2s;
        }

        .scroll-btn:hover {
            background: #8b0000;
            color: #fff;
        }

        .scroll-btn.left  { left: -20px; }
        .scroll-btn.right { right: -20px; }

        /* DOT INDICATORS */
        .scroll-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d1d5db;
            cursor: pointer;
            transition: all 0.25s;
        }

        .dot.active {
            background: #8b0000;
            width: 22px;
            border-radius: 4px;
        }

        /* EMPTY STATE */
        .insight-empty {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .insight-empty i {
            font-size: 48px;
            display: block;
            margin-bottom: 12px;
        }

        .insight-empty p {
            font-size: 15px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .scroll-btn { display: none; }

            .card-article-horizontal {
                min-width: 85%;
            }

            .scholarship-section {
                padding: 60px 0 50px;
            }
        }
    </style>

    <!-- SCRIPT -->
    <script>
        const CARD_WIDTH = 420;

        function scrollScholarship(direction) {
            const container = document.getElementById('scholarshipScroll');
            container.scrollBy({ left: direction * CARD_WIDTH, behavior: 'smooth' });
        }

        function scrollToCard(index) {
            const container = document.getElementById('scholarshipScroll');
            container.scrollTo({ left: index * CARD_WIDTH, behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('scholarshipScroll');
            if (!container) return;

            container.addEventListener('scroll', function () {
                const index = Math.round(container.scrollLeft / CARD_WIDTH);
                document.querySelectorAll('.dot').forEach((d, i) => {
                    d.classList.toggle('active', i === index);
                });
            });
        });
    </script>

</section>