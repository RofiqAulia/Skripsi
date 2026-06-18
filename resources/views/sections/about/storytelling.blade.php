<section class="why-exists">

    <div class="container-lg">
        <div class="row align-items-center gy-5">

            <!-- LEFT STORY -->
            <div class="col-lg-6">

                <h1 class="why-title">
                    Why SOVIA Exists
                </h1>

                <p class="why-text">
                    Every year, many talented employees aspire to pursue international education. 
                    However, most of them face the same uncertainty — where to begin and how to prepare effectively.
                </p>

                <p class="why-text">
                    Without proper guidance, even the most motivated individuals can feel overwhelmed 
                    by complex requirements and unclear direction.
                </p>

                <p class="why-highlight">
                    SOVIA transforms confusion into clarity — providing a structured path 
                    that turns ambition into measurable progress.
                </p>

            </div>

            <!-- RIGHT VISUAL (STEP LADDER) -->
            <div class="col-lg-6 d-flex justify-content-center">

                <div class="why-visual">

                    <div class="step-box step-1">Confusion</div>
                    <div class="step-box step-2">Guidance</div>
                    <div class="step-box step-3">Clarity</div>

                </div>

            </div>

        </div>
    </div>

    <style>
.why-exists {
    padding: 80px 0;
    background: linear-gradient(180deg, #ffffff, #f7f7f7);
}

/* TITLE */
.why-title {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* TEXT */
.why-text {
    color: #555;
    margin-bottom: 16px;
    line-height: 1.7;
    max-width: 520px;
}

/* HIGHLIGHT */
.why-highlight {
    margin-top: 20px;
    font-weight: 500;
    color: #8b0000;
    border-left: 4px solid #8b0000;
    padding-left: 15px;
}

/* =========================
   🔥 STEP VISUAL UPGRADE
========================= */

.why-visual {
    position: relative;
    width: 380px;
    height: 280px;
}

/* BASE BOX */
.step-box {
    position: absolute;
    width: 170px;
    height: 65px;
    border-radius: 14px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 14px;
    font-weight: 500;

    background: linear-gradient(
        145deg,
        #ffffff,
        #f1f1f1
    );

    border: 1px solid #eee;

    box-shadow:
        0 10px 25px rgba(0,0,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.8);

    transition: all 0.35s ease;
}

/* posisi tangga */
.step-1 {
    bottom: 0;
    left: 0;
}

.step-2 {
    bottom: 90px;
    left: 110px;
}

.step-3 {
    bottom: 180px;
    left: 220px;
}

/* STEP TERAKHIR (PREMIUM 🔥) */
.step-3 {
    background: linear-gradient(
        135deg,
        #8b0000,
        rgba(0,0,0,0.8)
    );
    color: #fff;

    border: none;

    box-shadow:
        0 20px 50px rgba(139,0,0,0.35),
        inset 0 1px 0 rgba(255,255,255,0.2);
}

/* HOVER EFFECT */
.step-box:hover {
    transform: translateY(-6px) scale(1.02);
}

/* CONNECTOR LINE (LEBIH HALUS) */
.why-visual::before {
    content: "";
    position: absolute;
    left: 15px;
    bottom: 15px;
    width: 280px;
    height: 2px;
    background: linear-gradient(
        to right,
        rgba(200,200,200,0.5),
        rgba(139,0,0,0.6)
    );
    transform: rotate(-38deg);
    transform-origin: left bottom;
}

/* GLOW DOT DI STEP AKHIR */
.step-3::after {
    content: "";
    position: absolute;
    top: -6px;
    right: -6px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ff4d4d;
    box-shadow: 0 0 10px rgba(255,77,77,0.8);
}

/* RESPONSIVE */
@media (max-width: 768px) {

    .why-title {
        font-size: 28px;
        text-align: center;
    }

    .why-text,
    .why-highlight {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .why-visual {
        transform: scale(0.9);
        margin: auto;
    }

}
</style>

</section>