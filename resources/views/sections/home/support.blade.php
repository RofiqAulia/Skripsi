<section class="support-section">

    <div class="container text-center">

        <!-- 🔥 HEADLINE -->
        <h2 class="support-title" data-lang-key="support-title">
            Supported by Leading Companies
        </h2>

        <!-- ✨ SUBTEXT -->
        <p class="support-subtext" data-lang-key="support-subtext">
            We are proud to be supported by top companies in the industry, providing our students with the best opportunities and resources to succeed in their careers.
        </p>

        <!-- 🚀 LOGO SLIDER -->
        <div class="logo-slider">

            <div class="logo-track">

                @php
                    $logos = [
                        'ikssg.png',
                        'kig.png',
                        'sbi-beton.png',
                        'semen-baturaja.png',
                        'semen-gresik.png',
                        'semen-internasional.png',
                        'semen-kupang.png',
                        'semen-logistik.png',
                        'semen-padang.png',
                        'semen-thanglong.png',
                        'semen-tonasa.png',
                        'sia.png',
                        'sib.png',
                        'siib.png',
                        'sisi.png',
                        'smi.png',
                        'utsg.png'
                    ];
                @endphp

                @for ($i = 0; $i < 2; $i++)
                    <div class="logo-group">

                        @foreach ($logos as $logo)
                            <div class="logo-item-wrapper">
                                <img src="{{ asset('images/logo/' . $logo) }}"
                                    alt="Company Logo"
                                    class="logo-item">
                            </div>
                        @endforeach

                    </div>
                @endfor

            </div>

        </div>

    </div>

    <!-- 🔥 STYLE -->
    <style>
        /* 🔥 SECTION (NYATU SAMA HERO) */
        .support-section {
            padding: 80px 0;
            position: relative;
            overflow: hidden;

            background: #ffffff;
        }

        /* 🔥 GLOW BACKGROUND */
        .support-section::before {
            content: "";
            position: absolute;
            inset: 0;

            background: radial-gradient(
                circle at 30% 50%,
                #ffffff,
                transparent 60%
            );

            z-index: 1;
        }

        .support-section .container {
            position: relative;
            z-index: 2;
        }

        /* TITLE */
        .support-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #000000;
        }

        /* SUBTEXT */
        .support-subtext {
            font-size: 16px;
            color: #000000;
            max-width: 600px;
            margin: 0 auto 40px;
        }

        /* SLIDER */
        .logo-slider {
            overflow: hidden;
            position: relative;
        }

        .logo-track {
            display: flex;
            width: max-content;
            animation: scrollLeft 25s linear infinite;
        }

        .logo-group {
            display: flex;
        }

        /* 🔥 LOGO WRAPPER (CIRCLE STYLE) */
        .logo-item-wrapper {
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-item {
            height: 100px;
            width: 100px;
            object-fit: contain;

            /* 🔥 BULAT */
            border-radius: 50%;
            padding: 10px;

            /* 🔥 GLASS CARD */
            background: #ffffff;
            backdrop-filter: blur(8px);

            /* 🔥 EFFECT */
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .logo-item:hover {
            transform: scale(1.1);
            opacity: 1;
            background: #ffffff;
        }

        /* ANIMATION */
        @keyframes scrollLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .logo-track:hover {
            animation-play-state: paused;
        }

        /* FADE EDGE */
        .logo-slider::before,
        .logo-slider::after {
            content: "";
            position: absolute;
            top: 0;
            width: 80px;
            height: 100%;
            z-index: 2;
        }

        .logo-slider::before {
            left: 0;
            background: linear-gradient(to right, #ffffff, transparent);
        }

        .logo-slider::after {
            right: 0;
            background: linear-gradient(to left, #ffffff, transparent);
        }

        /* MOBILE */
        @media (max-width: 768px) {

            .support-title {
                font-size: 24px;
            }

            .support-subtext {
                font-size: 14px;
            }

            .logo-item {
                height: 45px;
                width: 45px;
            }
        }
    </style>

</section>