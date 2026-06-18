<section class="about-quote">

    <div class="container-lg text-center">

        <p class="quote-text">
            “SOVIA is not just a platform — it is a structured pathway designed to guide every employee toward achieving global academic excellence with clarity and confidence.”
        </p>

        <div class="quote-author">
            — GM of Corporate Learning & Development
        </div>

    </div>

    <style>
    .about-quote {
        padding: 120px 0;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* QUOTE TEXT */
    .quote-text {
        font-size: 28px;
        font-weight: 500;
        line-height: 1.6;
        max-width: 800px;
        margin: auto;
        color: #222;
        position: relative;
    }

    /* BIG QUOTE ICON 🔥 */
    .quote-text::before {
        content: "“";
        position: absolute;
        top: -40px;
        left: -20px;
        font-size: 100px;
        color: rgba(139, 0, 0, 0.08);
        font-weight: bold;
    }

    /* AUTHOR */
    .quote-author {
        margin-top: 30px;
        font-size: 14px;
        color: #8b0000;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* OPTIONAL DECOR */
    .about-quote::after {
        content: "";
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 250px;
        height: 250px;
        background: rgba(139,0,0,0.05);
        border-radius: 50%;
        filter: blur(80px);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .quote-text {
            font-size: 22px;
        }
    }
    </style>

</section>