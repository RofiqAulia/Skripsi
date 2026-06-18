<nav id="mainNavbar"
     class="navbar navbar-expand-lg fixed-top">

    <div class="container-lg">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo-sovia.png') }}"
                 alt="SOVIA"
                 style="height:72px;">
        </a>

        <!-- TOGGLE -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse justify-content-center"
             id="navbarNav" style="visibility: visible;">

            <ul class="navbar-nav gap-lg-4 text-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" data-lang-key="nav-home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" data-lang-key="nav-about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('psp*') ? 'active' : '' }}" href="{{ route('psp') }}" data-lang-key="nav-psp">PSP</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('document*') ? 'active' : '' }}" href="{{ route('document') }}" data-lang-key="nav-document">Document</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('scholarship-application*') || request()->routeIs('financial-plan*') ? 'active' : '' }}" href="{{ route('scholarship-application.index') }}" data-lang-key="nav-financial-plan">Financial Plan</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('mentoring*') || request()->routeIs('report*') ? 'active' : '' }}" href="{{ route('mentoring') }}"
                    id="mentoringDropdown"
                    role="button"
                    aria-expanded="false"
                    data-lang-key="nav-mentoring">
                        Mentoring
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('report-mentoring') }}" data-lang-key="nav-report">Report Mentoring</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('mentoring') }}" data-lang-key="nav-mentor">Mentor</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}" data-lang-key="nav-dashboard">Dashboard</a>
                </li>

            </ul>
        </div>

        <!-- LANGUAGE TOGGLE + LOGIN BUTTON -->
        <div class="d-none d-lg-flex align-items-center gap-3">

            <!-- 🌐 LANGUAGE TOGGLE BUTTON -->
            <!-- <button id="langToggleBtn"
                    class="lang-toggle-btn"
                    onclick="toggleLanguage()"
                    aria-label="Toggle Language">
                <span class="flag-en">🇬🇧</span>
                <span class="flag-id" style="display:none">🇮🇩</span>
                <span class="lang-label">EN</span>
                <span class="lang-divider">|</span>
                <span class="lang-alt"></span>
            </button> -->

        @auth

            <div class="dropdown">
                <a class="btn btn-login dropdown-toggle d-flex align-items-center gap-2"
                href="#"
                data-bs-toggle="dropdown">

                    <i class="bi bi-person"></i>
                    {{ auth()->user()->name }}
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

        @else

    <a href="{{ route('login') }}"
       class="btn btn-login d-flex align-items-center gap-2"
       data-lang-key="nav-login">
        <i class="bi bi-person"></i>
        Login
    </a>

@endauth

</div>

    <!-- MOBILE LANG TOGGLE (inside collapse) -->
    <div class="d-lg-none collapse navbar-collapse" id="mobileLangWrapper" style="padding: 10px 0 0;">
        <!-- injected via JS into #navbarNav -->
    </div>

    </div>
</nav>

<style>
    /* 🔥 BASE NAVBAR */
    #mainNavbar {
        height: 90px;
        padding: 0;

        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(10px);

        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    /* 🔥 NAV LINK */
    #mainNavbar .nav-link {
        color: #111;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }

    /* underline hover modern */
    #mainNavbar .nav-link::after {
        content: "";
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0%;
        height: 2px;
        background: #8b0000;
        transition: 0.3s;
    }

    #mainNavbar .nav-link:hover::after {
        width: 100%;
    }

    #mainNavbar .nav-link:hover {
        color: #8b0000;
    }

    /* active state modern underline */
    #mainNavbar .nav-link.active::after {
        width: 100%;
    }

    #mainNavbar .nav-link.active {
        color: #8b0000;
    }

    /* 🔥 SCROLL EFFECT */
    #mainNavbar.scrolled {
        height: 75px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(14px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    /* 🔥 DROPDOWN */
    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 10px;
        display: none; /* hidden by default */
        margin-top: 0; /* Align directly under the nav-link */
    }

    /* 🔥 Show dropdown on hover (Desktop only) */
    @media (min-width: 992px) {
        #mainNavbar .dropdown:hover .dropdown-menu {
            display: block;
        }
    }

    .dropdown-item {
        border-radius: 8px;
        transition: 0.2s;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #8b0000;
    }

    /* 🔥 BUTTON LOGIN */
    #mainNavbar .btn-danger {
        border-radius: 30px;
        padding: 10px 24px;
        transition: all 0.3s ease;
    }

    #mainNavbar .btn-danger:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(220,53,69,0.3);
    }

    .btn-login {
        background: linear-gradient(135deg, #8b0000, #c40000);
        color: #fff;
        padding: 10px 22px;
        border-radius: 999px; /* pill */
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 18px rgba(139,0,0,0.3);
    }

    /* HOVER 🔥 */
    .btn-login:hover {
        background: linear-gradient(135deg, #a00000, #ff1a1a);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(139,0,0,0.4);
        color: #fff;
    }

    /* CLICK EFFECT */
    .btn-login:active {
        transform: scale(0.97);
    }

    /* 🔥 MOBILE FIX */
    @media (max-width: 991px) {

        #mainNavbar {
            height: auto;
            padding: 10px 0;
        }

        #mainNavbar .navbar-collapse {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-top: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        #mainNavbar .nav-link {
            padding: 10px 0;
        }

        /* center menu */
        #mainNavbar .navbar-nav {
            gap: 10px;
        }

        /* login button jadi full */
        #mainNavbar .btn-danger {
            width: 100%;
            margin-top: 10px;
        }

        .navbar-toggler-icon {
        filter: invert(0);
    }
    }

    /* ════════════════════════════
       🌐 LANGUAGE TOGGLE BUTTON
    ════════════════════════════ */
    .lang-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(139,0,0,0.07);
        border: 1.5px solid rgba(139,0,0,0.25);
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #8b0000;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        letter-spacing: 0.3px;
    }

    .lang-toggle-btn:hover {
        background: rgba(139,0,0,0.14);
        border-color: rgba(139,0,0,0.5);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(139,0,0,0.18);
    }

    .lang-toggle-btn .lang-divider {
        opacity: 0.35;
        margin: 0 2px;
    }

    .lang-toggle-btn .lang-alt {
        opacity: 0.5;
        font-weight: 400;
    }

    /* switching animation */
    .lang-toggle-btn.lang-switching {
        transform: scale(0.93);
        opacity: 0.7;
    }

    /* Mobile lang toggle */
    @media (max-width: 991px) {
        .lang-toggle-btn {
            width: 100%;
            justify-content: center;
            margin-top: 10px;
        }
    }
</style>

<script>
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('mainNavbar');

        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    /* ─── Inject mobile lang button into collapse menu ─── */
    document.addEventListener('DOMContentLoaded', function () {
        const collapseMenu = document.getElementById('navbarNav');
        if (!collapseMenu) return;

        const mobileLang = document.createElement('div');
        mobileLang.className = 'mt-2 d-lg-none';
        mobileLang.innerHTML = `
            <button id="langToggleBtnMobile"
                    class="lang-toggle-btn w-100 justify-content-center"
                    onclick="toggleLanguage()"
                    aria-label="Toggle Language">
                <span class="flag-en-m">🇬🇧</span>
                <span class="flag-id-m" style="display:none">🇮🇩</span>
                <span class="lang-label-m">EN</span>
            </button>
        `;
        collapseMenu.appendChild(mobileLang);

        /* sync mobile button on lang change */
        document.addEventListener('langChanged', function (e) {
            const lang = e.detail.lang;
            const fEN = document.querySelector('.flag-en-m');
            const fID = document.querySelector('.flag-id-m');
            const lbl = document.querySelector('.lang-label-m');
            if (!fEN) return;
            if (lang === 'en') {
                fEN.style.display = 'inline';
                fID.style.display = 'none';
                lbl.textContent = 'EN';
            } else {
                fEN.style.display = 'none';
                fID.style.display = 'inline';
                lbl.textContent = 'ID';
            }
        });
    });
</script>