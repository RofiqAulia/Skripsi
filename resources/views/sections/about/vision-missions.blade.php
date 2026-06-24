<section class="vision-mission">

    <div class="container-lg text-center">

        <!-- TITLE -->
        <h2 class="vm-title">
            Our Direction & Purpose
        </h2>

        <p class="vm-subtitle">
            Built to empower employees with clarity, structure, and global opportunities.
        </p>

        <div class="row justify-content-center mt-5 gy-4">

            <!-- VISION -->
            <div class="col-lg-5">

                <div class="vision-card">

                    <div class="vm-label">VISION</div>

                    <h1>
                        Becoming a Global Learning Enabler
                    </h1>

                    <p>
                        To create a future where every employee has clear access 
                        to international education pathways and grow beyond boundaries.
                    </p>

                </div>

            </div>

            <!-- MISSION -->
            <div class="col-lg-5">

                <div class="mission-card">

                    <div class="vm-label">MISSION</div>

                    <ul>
                        <li>Provide structured preparation pathways</li>
                        <li>Offer mentoring and expert guidance</li>
                        <li>Deliver real-time progress tracking</li>
                        <li>Simplify complex application processes</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

    <style>
.vision-mission {
    padding: 80px 0;
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
}

/* TITLE */
.vm-title {
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 10px;
}

.vm-subtitle {
    font-size: 16px;
    opacity: 0.85;
    max-width: 600px;
    margin: auto;
}

/* LABEL */
.vm-label {
    font-size: 11px;
    letter-spacing: 2px;
    font-weight: 600;
    margin-bottom: 12px;
    opacity: 0.7;
}

/* =========================
   🔥 VISION (GLASS PREMIUM)
========================= */
.vision-card {
    position: relative;
    padding: 28px;
    border-radius: 20px;
    text-align: left;
    height: 100%;

    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.12),
        rgba(255,255,255,0.05)
    );

    backdrop-filter: blur(14px);

    border: 1px solid rgba(255,255,255,0.15);

    box-shadow:
        0 10px 30px rgba(0,0,0,0.15),
        inset 0 1px 0 rgba(255,255,255,0.2);

    transition: all 0.35s ease;
}

/* glow line atas */
.vision-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 20px;
    width: 60px;
    height: 3px;
    background: #fff;
    opacity: 0.6;
    border-radius: 10px;
}

.vision-card h3 {
    font-size: 22px;
    margin-bottom: 12px;
}

.vision-card p {
    opacity: 0.9;
    line-height: 1.7;
}

/* hover elegant */
.vision-card:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow:
        0 20px 50px rgba(0,0,0,0.25),
        inset 0 1px 0 rgba(255,255,255,0.3);
}

/* =========================
   🚀 MISSION (LAYERED CARD)
========================= */
.mission-card {
    position: relative;
    background: #fff;
    color: #222;
    padding: 35px;
    border-radius: 20px;
    text-align: left;
    height: 100%;

    box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    transition: all 0.35s ease;
}

/* layer belakang */
.mission-card::after {
    content: "";
    position: absolute;
    bottom: -12px;
    right: -12px;
    width: 100%;
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(135deg, #8b0000, #c40000);
    z-index: -1;
    opacity: 0.15;
}

/* garis aksen kiri */
.mission-card::before {
    content: "";
    position: absolute;
    top: 30px;
    left: 0;
    width: 4px;
    height: 40px;
    background: linear-gradient(180deg, #8b0000, #c40000);
    border-radius: 4px;
}

.mission-card ul {
    padding-left: 0;
    list-style: none;
    margin: 0;
}

.mission-card li {
    position: relative;
    padding-left: 26px;
    margin-bottom: 14px;
    font-size: 15px;
}

/* bullet modern */
.mission-card li::before {
    content: "";
    position: absolute;
    left: 0;
    top: 7px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #8b0000;
}

/* hover */
.mission-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.3);
}

/* =========================
   📱 RESPONSIVE
========================= */
@media (max-width: 768px) {

    .vm-title {
        font-size: 28px;
    }

    .vision-card,
    .mission-card {
        padding: 25px;
    }

}
</style>