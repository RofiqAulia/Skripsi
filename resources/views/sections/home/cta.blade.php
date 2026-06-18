<section class="cta-full-image">

    <div class="cta-wrapper">

        <!-- LEFT TEXT -->
        <div class="cta-content">
            <h2 data-lang-key="cta-title">Design Your Global Career Path</h2>

            <p class="cta-sub" data-lang-key="cta-sub">
                Your journey to studying abroad starts here.
            </p>

            <p class="cta-desc" data-lang-key="cta-desc">
                Build a structured preparation plan, get mentorship, and consult 
                directly with the CLD team to achieve your academic goals.
            </p>

            <div class="cta-buttons">
                <a href="{{ auth()->check() ? route('psp') : route('login') }}" class="btn-primary" data-lang-key="cta-btn-primary">Get Started Now</a>
                <a href="{{ route('mentoring') }}" class="btn-consult" data-lang-key="cta-btn-consult">Talk to a Mentor</a>
            </div>
        </div>

    </div>

    <!-- FULL IMAGE RIGHT -->
    <div class="cta-image">
        <img src="images/study-aboard-4.png" alt="Study Abroad">
    </div>

    <style>
    .cta-full-image {
        position: relative;
        padding: 120px 0;
        background: #fff;
        overflow: hidden;
    }

    /* WRAPPER TEXT */
    .cta-wrapper {
        max-width: 1200px;
        margin: auto;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    /* CONTENT */
    .cta-content {
        width: 45%;
    }

    .cta-content h2 {
        font-size: 42px;
        font-weight: 700;
        color: #8b0000;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .cta-sub {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #111;
    }

    .cta-desc {
        color: #666;
        font-size: 15px;
        margin-bottom: 30px;
        line-height: 1.6;
        max-width: 450px;
    }

    /* BUTTON */
    .cta-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8b0000, #c40000);
        color: #fff;
        padding: 14px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-consult {
        border: 1.5px solid #8b0000;
        color: #8b0000;
        padding: 14px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: #a80000;
        transform: translateY(-3px);
    }

    .btn-consult:hover {
        background: #8b0000;
        color: #fff;
        transform: translateY(-3px);
    }

    /* IMAGE FULL RIGHT */
    .cta-image {
        position: absolute;
        top: 0;
        right: 0;
        width: 55%;
        height: 100%;
        z-index: 1;
    }

    .cta-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* GRADIENT BLEND */
    .cta-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to left,
            rgba(255,255,255,0),
            rgba(255,255,255,0.95)
        );
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .cta-content {
            width: 100%;
            text-align: center;
        }

        .cta-image {
            position: relative;
            width: 100%;
            height: 250px;
            margin-top: 30px;
        }

        .cta-buttons {
            justify-content: center;
        }
    }
    </style>

</section>