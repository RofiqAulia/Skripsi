<footer class="footer-modern">

    <div class="container-lg">

        <!-- MAIN FOOTER GRID -->
        <div class="footer-grid">

            <!-- BRAND COLUMN -->
            <div class="footer-brand">

                <img src="{{ asset('images/logo-sovia.png') }}"
                     alt="SOVIA"
                     class="footer-logo">

                <p class="footer-desc">
                    SOVIA is a leading platform for mentoring and scholarships,
                    empowering individuals to achieve global academic and career success.
                </p>

                <!-- SOCIAL ICONS -->
                <div class="footer-socials">
                    <a href="#" class="social-icon" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>

            </div>

            <!-- QUICK LINKS -->
            <div class="footer-col">
                <h6 class="footer-title">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="bi bi-chevron-right"></i> About</a></li>
                    <li><a href="{{ route('psp') }}"><i class="bi bi-chevron-right"></i> PSP</a></li>
                    <li><a href="{{ route('document') }}"><i class="bi bi-chevron-right"></i> Document</a></li>
                </ul>
            </div>

            <!-- RESOURCES -->
            <div class="footer-col">
                <h6 class="footer-title">Resources</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('mentoring') }}"><i class="bi bi-chevron-right"></i> Mentoring</a></li>
                    <li><a href="{{ route('dashboard') }}"><i class="bi bi-chevron-right"></i> Dashboard</a></li>
                    <li><a href="{{ route('insights.index') }}"><i class="bi bi-chevron-right"></i> Insights</a></li>
                    <li><a href="{{ route('report-mentoring') }}"><i class="bi bi-chevron-right"></i> Reports</a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div class="footer-col">
                <h6 class="footer-title">Get In Touch</h6>

                <div class="footer-contact-card">
                    <div class="fcc-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <span class="fcc-label">Corporate Learning & Dev</span>
                        <strong>PT Semen Indonesia (Persero) Tbk</strong>
                    </div>
                </div>

                <div class="footer-contact-card">
                    <div class="fcc-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <span class="fcc-label">Email Us</span>
                        <a href="mailto:cld@sig.co.id" class="fcc-link">cld@sig.id</a>
                    </div>
                </div>

            </div>

        </div>

        <!-- DIVIDER -->
        <div class="footer-divider"></div>

        <!-- BOTTOM BAR -->
        <div class="footer-bottom">
            <span>© {{ date('Y') }} <strong>SOVIA</strong> — SIG Academy. All Rights Reserved.</span>
            <!-- <span class="footer-bottom-right">
                Built with for scholarship excellence
            </span> -->
        </div>

    </div>

</footer>

<style>
/* ═══ FOOTER BASE ═══ */
.footer-modern {
    background: #f8f9fb;
    color: #555;
    padding: 60px 0 24px;
    position: relative;
}

/* ═══ GRID LAYOUT ═══ */
.footer-grid {
    display: grid;
    grid-template-columns: 1.3fr 0.8fr 0.8fr 1.1fr;
    gap: 48px;
}

/* ═══ BRAND ═══ */
.footer-logo {
    height: 60px;
    margin-bottom: 18px;
}

.footer-desc {
    font-size: 14px;
    line-height: 1.7;
    color: #888;
    max-width: 300px;
    margin: 0;
}

/* ═══ SOCIAL ICONS ═══ */
.footer-socials {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.social-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 10px;
    color: #777;
    font-size: 16px;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    text-decoration: none;
}

.social-icon:hover {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border-color: transparent;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(139,0,0,.25);
}

/* ═══ COLUMN TITLES ═══ */
.footer-title {
    color: #222;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.footer-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 28px;
    height: 2px;
    background: linear-gradient(135deg, #8b0000, #c40000);
    border-radius: 2px;
}

/* ═══ LINKS ═══ */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #777;
    text-decoration: none;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .25s ease;
}

.footer-links a i {
    font-size: 10px;
    color: #bbb;
    transition: .25s;
}

.footer-links a:hover {
    color: #8b0000;
    transform: translateX(4px);
}

.footer-links a:hover i {
    color: #c40000;
}

/* ═══ CONTACT CARDS ═══ */
.footer-contact-card {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.footer-contact-card:last-child { border-bottom: none; }

.fcc-icon {
    width: 36px;
    height: 36px;
    background: rgba(139,0,0,.06);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b0000;
    font-size: 15px;
    flex-shrink: 0;
}

.fcc-label {
    display: block;
    font-size: 11px;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 2px;
}

.fcc-link {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: .2s;
}

.fcc-link:hover { color: #8b0000; }

.fcc-text {
    color: #666;
    font-size: 13px;
}

.footer-contact-card strong {
    color: #444;
    font-size: 13px;
    font-weight: 500;
}

/* ═══ DIVIDER ═══ */
.footer-divider {
    margin: 48px 0 20px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #ddd, transparent);
}

/* ═══ BOTTOM BAR ═══ */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #999;
}

.footer-bottom strong { color: #555; }

.footer-bottom-right {
    display: flex;
    align-items: center;
    gap: 4px;
}

.footer-heart {
    color: #c40000;
    font-size: 11px;
    animation: heartbeat 1.5s ease infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 992px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 36px;
    }
}

@media (max-width: 576px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
        text-align: center;
    }

    .footer-desc { margin: 0 auto; }
    .footer-socials { justify-content: center; }
    .footer-title::after { left: 50%; transform: translateX(-50%); }
    .footer-links a { justify-content: center; }
    .footer-contact-card { justify-content: center; text-align: left; }
    .footer-bottom { flex-direction: column; gap: 8px; }
}
</style>