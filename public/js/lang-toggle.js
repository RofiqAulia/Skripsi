/**
 * =========================================================
 *  SOVIA – Language Toggle (EN ↔ ID)
 *  Pure JS, no backend required.
 *  Saves preference to localStorage.
 * =========================================================
 */

const TRANSLATIONS = {

    /* ──────────── NAVBAR ──────────── */
    'nav-home':       { en: 'Home',        id: 'Beranda' },
    'nav-about':      { en: 'About',       id: 'Tentang' },
    'nav-psp':        { en: 'PSP',         id: 'PSP' },
    'nav-document':   { en: 'Document',    id: 'Dokumen' },
    'nav-financial-plan': { en: 'Financial Plan', id: 'Rencana Keuangan' },
    'nav-mentoring':  { en: 'Mentoring',   id: 'Mentoring' },
    'nav-report':     { en: 'Report Mentoring', id: 'Laporan Mentoring' },
    'nav-mentor':     { en: 'Mentor',      id: 'Mentor' },
    'nav-dashboard':  { en: 'Dashboard',   id: 'Dasbor' },
    'nav-login':      { en: 'Login',       id: 'Masuk' },

    /* ──────────── HERO ──────────── */
    'hero-breadcrumb': { en: 'Home', id: 'Beranda' },
    'hero-title': {
        en: 'Empower Your Global Study Journey with Quality Mentorship',
        id: 'Wujudkan Perjalanan Global Anda dengan Mentorship Berkelas Dunia',
    },
    'hero-subtext': {
        en: 'Connect with the right mentors, build meaningful collaborations, and prepare your best steps toward achieving your academic and career goals in the future.',
        id: 'Temukan mentor yang tepat, berkolaborasi, dan melangkah yakin menuju masa depanmu. Lampaui Batas Selanjutnya.',
    },
    'hero-btn-primary':   { en: 'Start Your Journey', id: 'Mulai Perjalananmu' },
    'hero-btn-secondary': { en: 'Explore Program',    id: 'Jelajahi Program' },
    'hero-microcopy': {
        // en: 'Built to support employees in achieving international postgraduate success',
        // id: 'Dibangun untuk mendukung karyawan dalam meraih kesuksesan pascasarjana internasional',
    },
    'stat-scholarships': { en: 'Scholarships', id: 'Beasiswa' },
    'stat-mentors':      { en: 'Best Mentors', id: 'Mentor Terbaik' },
    'stat-applicants':   { en: 'Applicants',   id: 'Pendaftar' },

    /* ──────────── SUPPORT SECTION ──────────── */
    'support-title': {
        en: 'Supported by Leading Companies',
        id: 'Didukung oleh Perusahaan Terkemuka',
    },
    'support-subtext': {
        en: 'We are proud to be supported by top companies in the industry, providing our students with the best opportunities and resources to succeed in their careers.',
        id: 'Kami bangga didukung oleh perusahaan-perusahaan terkemuka di industri, memberikan peluang dan sumber daya terbaik bagi karyawan kami untuk sukses dalam karier mereka.',
    },

    /* ──────────── PROBLEM–SOLUTIONS ──────────── */
    'problem-title': {
        en: 'Starting Your Study Abroad Journey Can Be Overwhelming',
        id: 'Memulai Perjalanan Studi ke Luar Negeri Bisa Terasa Berat',
    },
    'problem-text': {
        en: 'Many employees struggle to understand where to begin, what requirements are needed, and how to prepare effectively.',
        id: 'Banyak karyawan kesulitan mengetahui dari mana harus memulai, apa persyaratannya, dan bagaimana mempersiapkan diri secara efektif.',
    },
    'problem-li-1': { en: 'Unclear starting point',           id: 'Titik awal yang tidak jelas' },
    'problem-li-2': { en: 'Complex document requirements',    id: 'Persyaratan dokumen yang rumit' },
    'problem-li-3': { en: 'Lack of proper guidance',          id: 'Kurangnya bimbingan yang tepat' },
    'problem-li-4': { en: 'No structured preparation plan',   id: 'Tidak ada rencana persiapan terstruktur' },
    'solution-title': {
        en: 'We Simplify Your Entire Preparation Journey',
        id: 'Kami Menyederhanakan Seluruh Perjalanan Persiapan Anda',
    },
    'solution-text': {
        en: 'Our platform provides a structured, step-by-step approach supported by expert mentors and real-time progress tracking.',
        id: 'Platform kami menyediakan pendekatan terstruktur langkah-demi-langkah yang didukung oleh mentor ahli dan pelacakan kemajuan secara real-time.',
    },
    'solution-highlight': {
        en: 'From planning to execution, everything is designed to help you succeed.',
        id: 'Dari perencanaan hingga pelaksanaan, semuanya dirancang untuk membantu Anda sukses.',
    },

    /* ──────────── FEATURES (HOW) ──────────── */
    'how-title': {
        en: 'Your Study Abroad Journey, Simplified',
        id: 'Perjalanan Studi ke Luar Negeri Anda, Disederhanakan',
    },
    'how-subtext': {
        en: 'A structured platform designed to help employees plan, prepare, and successfully achieve their international postgraduate goals.',
        id: 'Platform terstruktur yang dirancang untuk membantu karyawan merencanakan, mempersiapkan, dan meraih tujuan pascasarjana internasional mereka.',
    },
    'step-1-title': { en: 'Build Your Study Plan',       id: 'Buat Rencana Studi Anda' },
    'step-1-desc':  {
        en: 'Start with a personalized study plan tailored to your target university and readiness level.',
        id: 'Mulailah dengan rencana studi yang dipersonalisasi sesuai universitas target dan tingkat kesiapan Anda.',
    },
    'step-1-btn':   { en: 'Create PSP',       id: 'Buat PSP' },
    'step-2-title': { en: 'Prepare Your Documents',     id: 'Siapkan Dokumen Anda' },
    'step-2-desc':  {
        en: 'Organize and complete all required documents with structured guidance and templates.',
        id: 'Atur dan lengkapi semua dokumen yang diperlukan dengan panduan dan template terstruktur.',
    },
    'step-2-btn':   { en: 'View Documents',   id: 'Lihat Dokumen' },
    'step-3-title': { en: 'Get Mentorship Support',     id: 'Dapatkan Dukungan Mentor' },
    'step-3-desc':  {
        en: 'Connect with expert mentors who will guide and review your preparation process.',
        id: 'Hubungi mentor ahli yang akan membimbing dan meninjau proses persiapan Anda.',
    },
    'step-3-btn':   { en: 'Find a Mentor',    id: 'Cari Mentor' },
    'step-4-title': { en: 'Track Your Progress',        id: 'Pantau Kemajuan Anda' },
    'step-4-desc':  {
        en: 'Monitor your preparation journey and stay on track with a measurable dashboard.',
        id: 'Pantau perjalanan persiapan Anda dan tetap sesuai jalur dengan dasbor terukur.',
    },
    'step-4-btn':   { en: 'Open Dashboard',   id: 'Buka Dasbor' },

    /* ──────────── SCHOLARSHIP / INSIGHTS ──────────── */
    'scholarship-eyebrow': { en: 'Latest Updates',   id: 'Pembaruan Terkini' },
    'scholarship-title':   { en: 'Scholarship Insights', id: 'Wawasan Beasiswa' },
    'scholarship-subtext': {
        en: 'Stay updated with the latest scholarship opportunities, tips, and guides to help you succeed.',
        id: 'Tetap terupdate dengan peluang beasiswa terbaru, tips, dan panduan untuk membantu Anda sukses.',
    },
    'scholarship-btn-all': { en: 'Explore All Insights →', id: 'Jelajahi Semua Wawasan →' },
    'scholarship-read-more': { en: 'Read Article →', id: 'Baca Artikel →' },
    'scholarship-empty': {
        en: 'No scholarship insights published yet. Check back soon!',
        id: 'Belum ada wawasan beasiswa yang diterbitkan. Cek kembali nanti!',
    },

    /* ──────────── WHY-PROGRAM ──────────── */
    'why-title':     { en: 'Your Future Starts Here',                             id: 'Masa Depanmu Dimulai di Sini' },
    'why-highlight': { en: 'Unlock global opportunities through structured preparation', id: 'Buka peluang global melalui persiapan terstruktur' },
    'why-1-title': { en: 'Clear Study Direction',  id: 'Arah Studi yang Jelas' },
    'why-1-desc':  { en: 'Build a personalized plan aligned with your career vision.', id: 'Buat rencana yang dipersonalisasi sesuai visi karier Anda.' },
    'why-2-title': { en: 'Expert Mentorship',      id: 'Mentorship dari Ahlinya' },
    'why-2-desc':  { en: 'Get guidance from professionals with real global experience.', id: 'Dapatkan bimbingan dari profesional berpengalaman di kancah global.' },
    'why-3-title': { en: 'Document Readiness',     id: 'Kesiapan Dokumen' },
    'why-3-desc':  { en: 'Prepare every requirement with clarity and efficiency.', id: 'Siapkan setiap persyaratan dengan jelas dan efisien.' },
    'why-4-title': { en: 'Progress Tracking',      id: 'Pelacakan Kemajuan' },
    'why-4-desc':  { en: 'Track your journey with a structured and transparent system.', id: 'Pantau perjalanan Anda dengan sistem terstruktur dan transparan.' },

    /* ──────────── CTA ──────────── */
    'cta-title':   { en: 'Design Your Global Career Path',       id: 'Rancang Jalur Karier Global Anda' },
    'cta-sub':     { en: 'Your journey to studying abroad starts here.', id: 'Perjalanan studi ke luar negeri Anda dimulai di sini.' },
    'cta-desc':    {
        en: 'Build a structured preparation plan, get mentorship, and consult directly with the CLD team to achieve your academic goals.',
        id: 'Buat rencana persiapan terstruktur, dapatkan mentorship, dan konsultasikan langsung dengan tim CLD untuk meraih tujuan akademis Anda.',
    },
    'cta-btn-primary': { en: 'Get Started Now',  id: 'Mulai Sekarang' },
    'cta-btn-consult': { en: 'Choose Your Mentor', id: 'Pilih Mentor Mu' },

    /* ──────────── FOOTER ──────────── */
    'footer-tagline': {
        en: 'Empowering your global academic journey.',
        id: 'Memberdayakan perjalanan akademis global Anda.',
    },
    'footer-quick-links': { en: 'Quick Links', id: 'Tautan Cepat' },
    'footer-resources':   { en: 'Resources',   id: 'Sumber Daya' },
    'footer-copyright': {
        en: '© 2025 SOVIA. All rights reserved.',
        id: '© 2025 SOVIA. Seluruh hak dilindungi.',
    },
};

/* ─────────────────────────────────────────────────────────────
   CORE ENGINE
───────────────────────────────────────────────────────────── */

function applyLanguage(lang) {
    document.querySelectorAll('[data-lang-key]').forEach(el => {
        const key = el.getAttribute('data-lang-key');
        if (TRANSLATIONS[key] && TRANSLATIONS[key][lang]) {
            // Use innerHTML for elements that may contain HTML
            if (el.dataset.langHtml) {
                el.innerHTML = TRANSLATIONS[key][lang];
            } else {
                el.textContent = TRANSLATIONS[key][lang];
            }
        }
    });

    // Update toggle button appearance
    const toggleBtn = document.getElementById('langToggleBtn');
    if (toggleBtn) {
        const flagEN = toggleBtn.querySelector('.flag-en');
        const flagID = toggleBtn.querySelector('.flag-id');
        const labelEl = toggleBtn.querySelector('.lang-label');

        if (lang === 'en') {
            flagEN && (flagEN.style.display = 'inline');
            flagID && (flagID.style.display = 'none');
            if (labelEl) labelEl.textContent = 'EN';
        } else {
            flagEN && (flagEN.style.display = 'none');
            flagID && (flagID.style.display = 'inline');
            if (labelEl) labelEl.textContent = 'ID';
        }
    }

    // Update html lang attribute
    document.documentElement.lang = lang === 'id' ? 'id' : 'en';

    // Save preference
    localStorage.setItem('sovia_lang', lang);

    // Dispatch event for other scripts
    document.dispatchEvent(new CustomEvent('langChanged', { detail: { lang } }));
}

function toggleLanguage() {
    const current = localStorage.getItem('sovia_lang') || 'en';
    const next    = current === 'en' ? 'id' : 'en';

    const btn = document.getElementById('langToggleBtn');
    if (btn) {
        btn.classList.add('lang-switching');
        setTimeout(() => btn.classList.remove('lang-switching'), 400);
    }

    applyLanguage(next);
}

/* ─────────────────────────────────────────────────────────────
   INIT on DOM ready
───────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('sovia_lang') || 'en';
    applyLanguage(saved);
});
