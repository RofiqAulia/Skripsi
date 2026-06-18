<section class="problem-solution">

    <div class="container-lg">
        <div class="row align-items-center">

            <!-- LEFT -->
            <div class="col-lg-6 mb-5 mb-lg-0">

                <h2 class="section-title text-dark" data-lang-key="problem-title">
                    Starting Your Study Abroad Journey Can Be Overwhelming
                </h2>

                <p class="section-text" data-lang-key="problem-text">
                    Many employees struggle to understand where to begin, what requirements are needed, and how to prepare effectively.
                </p>

                <ul class="problem-list">
                    <li data-lang-key="problem-li-1">Unclear starting point</li>
                    <li data-lang-key="problem-li-2">Complex document requirements</li>
                    <li data-lang-key="problem-li-3">Lack of proper guidance</li>
                    <li data-lang-key="problem-li-4">No structured preparation plan</li>
                </ul>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="solution-wrapper">

                    <!-- BACK LAYER -->
                    <div class="solution-layer"></div>

                    <!-- MAIN CARD -->
                    <div class="solution-box">

                        <h3 data-lang-key="solution-title">
                            We Simplify Your Entire Preparation Journey
                        </h3>

                        <p data-lang-key="solution-text">
                            Our platform provides a structured, step-by-step approach supported by expert mentors and real-time progress tracking.
                        </p>

                        <div class="solution-highlight" data-lang-key="solution-highlight">
                            From planning to execution, everything is designed to help you succeed.
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <style>

    .problem-solution {
        padding: 110px 0;
        background: linear-gradient(180deg, #ffffff, #fafafa);
    }

    .section-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .section-text {
        font-size: 16px;
        color: #555;
        margin-bottom: 20px;
        max-width: 500px;
    }

    .problem-list {
        list-style: none;
        padding: 0;
    }

    .problem-list li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 12px;
        font-size: 15px;
        color: #333;
    }

    .problem-list li::before {
        content: "⚠";
        position: absolute;
        left: 0;
        color: #8b0000;
        font-weight: bold;
    }

    /* =========================
       🔥 LAYERED CARD SYSTEM
    ========================== */

    .solution-wrapper {
        position: relative;
        max-width: 520px;
    }

    /* BACK LAYER (EFEK NGANGKAT) */
    .solution-layer {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 100%;
        height: 100%;
        background: #8b0000;
        border-radius: 24px;
        filter: blur(0px);
        opacity: 0.15;
        z-index: 1;
    }

    /* MAIN CARD */
    .solution-box {
        position: relative;
        z-index: 2;
        background: #fff;
        padding: 45px;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.12);
        transition: 0.4s ease;
    }

    /* HOVER EFFECT 🔥 */
    .solution-wrapper:hover .solution-box {
        transform: translateY(-8px);
        box-shadow: 0 35px 80px rgba(139,0,0,0.25);
    }

    .solution-wrapper:hover .solution-layer {
        transform: translateY(6px);
        opacity: 0.25;
    }

    .solution-box h3 {
        font-size: 26px;
        margin-bottom: 15px;
    }

    .solution-box p {
        color: #555;
        margin-bottom: 20px;
    }

    /* HIGHLIGHT */
    .solution-highlight {
        background: linear-gradient(135deg, #8b0000, #c40000);
        color: #fff;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 10px 30px rgba(139,0,0,0.3);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .section-title {
            font-size: 28px;
        }

        .solution-box {
            padding: 30px;
        }
    }

    </style>

</section>