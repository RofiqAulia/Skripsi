<section class="hero-home">

    <div class="container-lg h-100">
        <div class="row align-items-center h-100">

            <!-- LEFT: TEXT -->
            <div class="col-lg-6 text-content pe-lg-5">

                <!-- 🔄 BREADCRUMB -->
                <div class="hero-breadcrumb mb-3">
                    {{ $menu ?? 'About' }}
                    @if(isset($submenu))
                        → {{ $submenu }}
                    @endif
                </div>

                <!-- 📝 HEADLINE -->
                <h1 class="hero-title">
                    Empowering Ambitions,<br>Bridging Futures
                </h1>

                <!-- 📄 SUBTEXT -->
                <p class="hero-subtext mt-3">
                    SOVIA is more than a platform. It's your strategic partner in conquering global scholarships through structured preparation and dedicated guidance.
                </p>

            </div>

            <!-- RIGHT: IMAGE + STATS -->
            <div class="col-lg-6 d-flex justify-content-center align-items-center position-relative mt-4 mt-lg-2">

                <img src="{{ asset('images/hero-scholarship.webp') }}"
                     alt="About SOVIA"
                     class="hero-image">
                
                <!-- 🔥 FLOATING STATS -->
                <!-- <div class="hero-stats">
                    <div class="stat-item">
                        <h4>100%</h4>
                        <span>Support</span>
                    </div>
                    <div class="stat-item">
                        <h4>Global</h4>
                        <span>Network</span>
                    </div>
                    <div class="stat-item">
                        <h4>Proven</h4>
                        <span>Excellence</span>
                    </div>
                </div> -->

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

            background: url("{{ asset('images/s-innovation.jpg') }}") center/cover no-repeat;
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

        /* 🔥 DESKTOP FLOATING */
        .hero-stats {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);

            display: flex;
            gap: 20px;

            background: rgba(255,255,255,0.95);
            padding: 16px 24px;
            border-radius: 16px;

            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        .stat-item {
            text-align: center;
            min-width: 80px;
        }

        .stat-item h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #8b0000;
        }

        .stat-item span {
            font-size: 12px;
            color: #666;
        }

        @media (max-width: 768px) {

            .hero-image-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-stats {
                position: static;
                transform: none;

                margin-top: 20px;
                width: 100%;

                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;

                padding: 16px;
            }

            .stat-item {
                flex: 1 1 30%;
                min-width: 70px;
            }
        }
    </style>

</section>