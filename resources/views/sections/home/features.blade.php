<section class="how-section">

    <div class="container text-center">

        <!-- TITLE -->
        <h2 class="how-title" data-lang-key="how-title">
            Your Study Abroad Journey, Simplified
        </h2>

        <p class="how-subtext" data-lang-key="how-subtext">
            A structured platform designed to help employees plan, prepare, and successfully achieve their international postgraduate goals.
        </p>

        <!-- STEPS (static, translated via JS) -->
        <div class="row g-4 mt-5">

            @php
                $steps = [
                    [
                        'title_key' => 'step-1-title',
                        'desc_key'  => 'step-1-desc',
                        'btn_key'   => 'step-1-btn',
                        'title' => 'Build Your Study Plan',
                        'desc'  => 'Start with a personalized study plan tailored to your target university and readiness level.',
                        'btn'   => 'Create PSP',
                        'link'  => route('psp'),
                        'image' => 'study-planning.jpg',
                        'icon'  => 'bi-journal-bookmark-fill',
                    ],
                    [
                        'title_key' => 'step-2-title',
                        'desc_key'  => 'step-2-desc',
                        'btn_key'   => 'step-2-btn',
                        'title' => 'Prepare Your Documents',
                        'desc'  => 'Organize and complete all required documents with structured guidance and templates.',
                        'btn'   => 'View Documents',
                        'link'  => route('document'),
                        'image' => 'prepare-document.jpg',
                        'icon'  => 'bi-folder2-open',
                    ],
                    [
                        'title_key' => 'step-3-title',
                        'desc_key'  => 'step-3-desc',
                        'btn_key'   => 'step-3-btn',
                        'title' => 'Get Mentorship Support',
                        'desc'  => 'Connect with expert mentors who will guide and review your preparation process.',
                        'btn'   => 'Find a Mentor',
                        'link'  => route('mentoring'),
                        'image' => 'mentorship.webp',
                        'icon'  => 'bi-people-fill',
                    ],
                    [
                        'title_key' => 'step-4-title',
                        'desc_key'  => 'step-4-desc',
                        'btn_key'   => 'step-4-btn',
                        'title' => 'Track Your Progress',
                        'desc'  => 'Monitor your preparation journey and stay on track with a measurable dashboard.',
                        'btn'   => 'Open Dashboard',
                        'link'  => route('dashboard'),
                        'image' => 'tracking-progress.webp',
                        'icon'  => 'bi-bar-chart-line-fill',
                    ],
                ];
            @endphp

            @foreach ($steps as $index => $step)
            <div class="col-lg-3 col-md-6">

                <a href="{{ $step['link'] }}" class="how-card-link">
                    <div class="how-card">

                        <!-- IMAGE BG -->
                        <img src="{{ asset('images/' . $step['image']) }}" class="bg-img" alt="{{ $step['title'] }}">

                        <!-- OVERLAY -->
                        <div class="overlay"></div>

                        <!-- STEP BADGE -->
                        <div class="step-badge">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                        <!-- CONTENT -->
                        <div class="how-content">
                            <i class="bi {{ $step['icon'] }} how-icon"></i>
                            <h5 data-lang-key="{{ $step['title_key'] }}">{{ $step['title'] }}</h5>
                            <p data-lang-key="{{ $step['desc_key'] }}">{{ $step['desc'] }}</p>

                            <span class="btn-step" data-lang-key="{{ $step['btn_key'] }}">
                                {{ $step['btn'] }} →
                            </span>
                        </div>

                    </div>
                </a>

            </div>
            @endforeach

        </div>

        <!-- CTA -->
        <!-- <div class="text-center mt-5">
            <a href="{{ auth()->check() ? route('psp') : route('login') }}" class="btn-main">
                Start Your Preparation →
            </a>
        </div> -->

    </div>

    <style>

        .how-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #8b0000, #c40000);
            color: #fff;
        }

        .how-title {
            font-size: 36px;
            font-weight: 700;
        }

        .how-subtext {
            max-width: 650px;
            margin: 10px auto 40px;
            color: rgba(255,255,255,0.8);
        }

        /* CARD LINK WRAPPER */
        .how-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        /* CARD */
        .how-card {
            position: relative;
            height: 320px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .how-card-link:hover .how-card {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        /* BG IMAGE */
        .bg-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .how-card-link:hover .bg-img {
            transform: scale(1.08);
        }

        /* STEP BADGE */
        .step-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 3;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.4);
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* DARK RED OVERLAY */
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(139,0,0,0.9),
                rgba(139,0,0,0.6),
                rgba(0,0,0,0.2)
            );
        }

        /* CONTENT */
        .how-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: left;
            z-index: 2;
        }

        .how-icon {
            font-size: 22px;
            color: rgba(255,255,255,0.85);
            display: block;
            margin-bottom: 8px;
        }

        .how-content h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #fff;
        }

        .how-content p {
            font-size: 13px;
            color: rgba(255,255,255,0.8);
            line-height: 1.5;
            margin-bottom: 10px;
        }

        /* BUTTON */
        .btn-step {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            padding: 5px 14px;
            border-radius: 50px;
            backdrop-filter: blur(4px);
            transition: background 0.2s, border-color 0.2s;
        }

        .how-card-link:hover .btn-step {
            background: rgba(255,255,255,0.28);
            border-color: rgba(255,255,255,0.6);
        }

        /* CTA */
        .btn-main {
            background: #fff;
            color: #8b0000;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-main:hover {
            transform: translateY(-2px);
            background: #f3f3f3;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .how-title {
                font-size: 26px;
            }

            .how-card {
                height: 260px;
            }
        }

    </style>

</section>