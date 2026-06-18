<section class="why-program-red">
    <div class="container">

        <div class="why-header text-center" data-aos="fade-up">
            <h2 data-lang-key="why-title">Your Future Starts Here</h2>
            <p class="highlight" data-lang-key="why-highlight">
                Unlock global opportunities through structured preparation
            </p>
        </div>

        <div class="why-grid-modern">

            <div class="why-card-modern" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-wrap">🎓</div>
                <h5 data-lang-key="why-1-title">Clear Study Direction</h5>
                <p data-lang-key="why-1-desc">Build a personalized plan aligned with your career vision.</p>
            </div>

            <div class="why-card-modern" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-wrap">🤝</div>
                <h5 data-lang-key="why-2-title">Expert Mentorship</h5>
                <p data-lang-key="why-2-desc">Get guidance from professionals with real global experience.</p>
            </div>

            <div class="why-card-modern" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-wrap">📄</div>
                <h5 data-lang-key="why-3-title">Document Readiness</h5>
                <p data-lang-key="why-3-desc">Prepare every requirement with clarity and efficiency.</p>
            </div>

            <div class="why-card-modern" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-wrap">📊</div>
                <h5 data-lang-key="why-4-title">Progress Tracking</h5>
                <p data-lang-key="why-4-desc">Track your journey with a structured and transparent system.</p>
            </div>

        </div>

    </div>
</section>

<style>

/* RESET OPTIONAL */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

/* CONTAINER */
.container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
}

/* SECTION */
.why-program-red {
    padding: 100px 20px;
    background: fff;
    position: relative;
    overflow: hidden;
}

/* HEADER */
.why-header {
    text-align: center;
}

.why-header h2 {
    color: #111;
    font-size: 38px;
    font-weight: 700;
    margin-bottom: 10px;
}

.why-header .highlight {
    color: #666;
    font-size: 16px;
}

/* GRID */
.why-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
    margin-top: 60px;
}

/* CARD */
.why-card-modern {
    position: relative;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(12px);
    border-radius: 25px;
    padding: 35px 25px;
    text-align: center;
    transition: all 0.35s ease;
    overflow: hidden;
}

/* BORDER GLOW */
.why-card-modern::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 25px;
    padding: 1px;
    background: linear-gradient(135deg, #ff4d4d, transparent);
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
            mask-composite: exclude;
}

/* ICON */
.icon-wrap {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b0000, #ff4d4d);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: 0.3s;
}

/* TITLE */
.why-card-modern h5 {
    font-size: 18px;
    font-weight: 600;
    color: #111;
    margin-bottom: 10px;
}

/* DESC */
.why-card-modern p {
    font-size: 14px;
    color: #555;
}

/* HOVER EFFECT */
.why-card-modern:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0,0,0,0.25);
}

.why-card-modern:hover .icon-wrap {
    transform: scale(1.1) rotate(5deg);
}

/* BACKGROUND DECOR */
.why-program-red::after {
    content: "";
    position: absolute;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    top: -100px;
    right: -100px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .why-header h2 {
        font-size: 28px;
    }

    .why-card-modern {
        padding: 25px;
    }
}

</style>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>