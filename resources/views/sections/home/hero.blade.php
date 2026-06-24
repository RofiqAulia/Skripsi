<section class="hero-home">

    <div class="container-lg h-100">
        <div class="row align-items-center h-100">

            <!-- LEFT: TEXT -->
            <div class="col-lg-6 text-content pe-lg-5">

                <!-- 🔄 BREADCRUMB -->
                <div class="hero-breadcrumb mb-3">
                    <span data-lang-key="hero-breadcrumb">{{ $menu ?? 'Home' }}</span>
                    @if(isset($submenu))
                        → {{ $submenu }}
                    @endif
                </div>

                <!-- 📝 HEADLINE -->
                <h1 class="hero-title" data-lang-key="hero-title">
                    Empower Your Global Study Journey with Quality Mentorship
                </h1>

                <!-- 📄 SUBTEXT -->
                <p class="hero-subtext mt-3" data-lang-key="hero-subtext">
                    Connect with the right mentors, build meaningful collaborations, and prepare your best steps toward achieving your academic and career goals in the future.
                </p>
                

                <!-- 🔘 CTA -->
                <div class="hero-cta mt-4 d-flex gap-3 flex-wrap">

                    <!-- PRIMARY CTA -->
                    <a href="{{ auth()->check() ? route('psp') : route('login') }}" class="btn hero-btn-primary" data-lang-key="hero-btn-primary">
                        Start Your Journey
                    </a>

                    <!-- SECONDARY CTA -->
                    <a href="{{ auth()->check() ? route('about') : route('login') }}" class="btn hero-btn-secondary" data-lang-key="hero-btn-secondary">
                        Explore Program
                    </a>

                </div>

                <!-- <small class="hero-microcopy" data-lang-key="hero-microcopy">
                    Built to support employees in achieving international postgraduate success
                </small> -->

            </div>

            <!-- RIGHT: IMAGE + STATS -->
            <div class="col-lg-6 d-flex justify-content-center align-items-center position-relative mt-4 mt-lg-2">

                <img src="{{ asset('images/header-web-sigid-01c.jpg') }}"
                     alt="Mentoring"
                     class="hero-image">

            </div>

        </div>
    </div>

    <!-- STYLE -->
    <style>
        .hero-home {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 120px;
            padding-bottom: 80px;

            background: url("{{ asset('images/mega-ppid.jpg') }}") center/cover no-repeat;
            color: #fff;
            overflow: hidden;
        }

        /* 🔥 GRADIENT OVERLAY PREMIUM */
        .hero-home::before {
            content: "";
            position: absolute;
            inset: 0;

            background: linear-gradient(
                135deg,
                #8b0000,
                rgba(0,0,0,0.3)
            );

            z-index: 1;
        }

        .hero-home .container {
            position: relative;
            z-index: 2;
        }

        .hero-home .container-lg {
            position: relative;
            z-index: 2;
        }

        /* TEXT */
        .hero-breadcrumb {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }

        .hero-title {
            font-size: 48px;
            line-height: 1.2;
        }

        .hero-subtext {
            font-size: 18px;
            line-height: 1.6;
            color: rgba(255,255,255,0.85);
            max-width: 500px;
        }

        /* CTA WRAPPER */
        .hero-cta {
            align-items: center;
            margin-top: 28px;
            gap: 16px;
        }

        /* PRIMARY BUTTON (MAIN ACTION) */
        .hero-btn-primary {
            border-radius: 999px;
            background: linear-gradient(135deg, #ffffff, #f5f5f5);
            color: #8b0000;
            padding: 14px 34px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        /* 🔥 FIX SECONDARY BIAR KELIHATAN */
        .hero-btn-secondary {
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,0.8);
            color: #fff;
            padding: 14px 34px;
            font-weight: 500;
            backdrop-filter: blur(6px);
            background: rgba(255,255,255,0.08);
            transition: all 0.3s ease;
        }

        .hero-btn-secondary:hover {
            background: #fff;
            color: #8b0000;
            border-color: #fff;
        }

        .hero-microcopy {
            display: block;
            margin-top: 14px;
            font-size: 14px;
            color: rgba(255,255,255,0.75);
            letter-spacing: 0.3px;
        }

        .hero-image-wrapper {
            position: relative;
            display: inline-block;
        }

        .hero-image {
            width: 100%;
            max-width: 550px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        @media (max-width: 768px) {

            .hero-image-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
            }


        }
    </style>

</section>