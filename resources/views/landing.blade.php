<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f4ed">
    <meta name="description" content="Borrow what you need, share what you have. Circlo makes it easy to share more with your community.">
    <title>Circlo — Borrow. Share. Make it count.</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #203b32;
            --muted: #64736a;
            --paper: #f5f4ed;
            --white: #fffefa;
            --green: #2f604d;
            --lime: #d7ed9f;
            --orange: #e98b5e;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page-shell {
            width: min(1120px, calc(100% - 48px));
            margin: 0 auto;
        }

        .site-header {
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand-mark {
            width: 31px;
            height: 31px;
            display: grid;
            place-items: center;
            border: 2px solid currentColor;
            border-radius: 50%;
            font-size: 16px;
            line-height: 1;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:not(.button):hover,
        .text-link:hover {
            color: var(--green);
        }

        .button {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            border: 1px solid var(--ink);
            border-radius: 999px;
            background: var(--ink);
            color: var(--white);
            font-size: 14px;
            font-weight: 700;
            transition: transform 160ms ease, background 160ms ease;
        }

        .button:hover {
            transform: translateY(-2px);
            background: var(--green);
        }

        .button-light {
            border-color: rgba(32, 59, 50, 0.25);
            background: transparent;
            color: var(--ink);
        }

        .button-light:hover {
            background: rgba(255, 254, 250, 0.65);
        }

        .hero {
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.03fr 0.97fr;
            align-items: center;
            gap: 50px;
            padding: 44px 0 78px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin: 0 0 23px;
            color: var(--green);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .eyebrow::before {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--orange);
            content: "";
        }

        h1 {
            max-width: 590px;
            margin: 0;
            font-size: clamp(52px, 6.2vw, 82px);
            font-weight: 650;
            letter-spacing: -5.8px;
            line-height: 0.99;
        }

        h1 span {
            color: var(--green);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            font-style: italic;
            letter-spacing: -5px;
        }

        .hero-copy {
            max-width: 445px;
            margin: 25px 0 30px;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .hero-note {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 32px;
            color: var(--muted);
            font-size: 12px;
        }

        .avatars {
            display: flex;
            padding-left: 5px;
        }

        .avatar {
            width: 27px;
            height: 27px;
            display: grid;
            place-items: center;
            margin-left: -5px;
            border: 2px solid var(--paper);
            border-radius: 50%;
            background: #eab89b;
            color: var(--ink);
            font-size: 9px;
            font-weight: 800;
        }

        .avatar:nth-child(2) { background: #d5dfad; }
        .avatar:nth-child(3) { background: #c1d9d4; }

        .hero-art {
            min-height: 440px;
            position: relative;
            display: grid;
            place-items: center;
        }

        .art-orbit {
            width: min(390px, 90%);
            aspect-ratio: 1;
            position: absolute;
            border: 1px solid rgba(47, 96, 77, 0.18);
            border-radius: 50%;
        }

        .art-orbit::before,
        .art-orbit::after {
            position: absolute;
            border: 1px solid rgba(47, 96, 77, 0.12);
            border-radius: 50%;
            content: "";
        }

        .art-orbit::before { inset: 25px; }
        .art-orbit::after { inset: 52px; }

        .item-card {
            width: min(290px, 72%);
            position: relative;
            z-index: 1;
            padding: 14px;
            transform: rotate(-4deg);
            border-radius: 21px;
            background: var(--white);
            box-shadow: 0 24px 70px rgba(32, 59, 50, 0.15);
        }

        .item-art {
            height: 246px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 13px;
            background: #d9e3ca;
        }

        .item-art svg {
            width: 84%;
            height: 84%;
        }

        .item-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 15px 3px 4px;
        }

        .item-details strong {
            display: block;
            font-size: 15px;
            letter-spacing: -0.3px;
        }

        .item-details small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .item-tag {
            padding: 8px 10px;
            border-radius: 99px;
            background: var(--lime);
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .float-note {
            position: absolute;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 12px 15px;
            border: 1px solid rgba(32, 59, 50, 0.08);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 12px 35px rgba(32, 59, 50, 0.09);
            font-size: 12px;
            font-weight: 700;
        }

        .float-note span {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #f8dfcf;
            font-size: 14px;
        }

        .note-top { top: 72px; right: 2px; transform: rotate(4deg); }
        .note-bottom { bottom: 69px; left: 3px; transform: rotate(-3deg); }

        .how-section {
            padding: 75px 0 92px;
            border-top: 1px solid rgba(32, 59, 50, 0.13);
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 38px;
        }

        .section-heading .eyebrow {
            margin-bottom: 13px;
        }

        h2 {
            max-width: 550px;
            margin: 0;
            font-size: clamp(34px, 4vw, 48px);
            font-weight: 600;
            letter-spacing: -2.7px;
            line-height: 1.08;
        }

        .section-intro {
            max-width: 340px;
            margin: 0 0 4px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .step-card {
            min-height: 203px;
            padding: 25px;
            border: 1px solid rgba(32, 59, 50, 0.11);
            border-radius: 17px;
            background: rgba(255, 254, 250, 0.55);
        }

        .step-number {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;
            margin-bottom: 25px;
            border-radius: 50%;
            background: var(--lime);
            color: var(--ink);
            font-size: 12px;
            font-weight: 800;
        }

        .step-card h3 {
            margin: 0 0 9px;
            font-size: 17px;
            letter-spacing: -0.5px;
        }

        .step-card p {
            max-width: 290px;
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.65;
        }

        .site-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 0 30px;
            border-top: 1px solid rgba(32, 59, 50, 0.13);
            color: var(--muted);
            font-size: 12px;
        }

        .footer-brand {
            color: var(--ink);
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        @media (max-width: 760px) {
            .page-shell { width: min(100% - 36px, 560px); }
            .site-header { height: 73px; }
            .nav-links { gap: 17px; }
            .nav-links > a:first-child { display: none; }
            .nav-links .button { min-height: 40px; padding: 0 15px; }
            .hero {
                min-height: auto;
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 47px 0 62px;
            }
            h1 { max-width: 530px; font-size: clamp(53px, 12vw, 76px); }
            .hero-art { min-height: 380px; }
            .item-card { width: 260px; }
            .item-art { height: 220px; }
            .art-orbit { width: 340px; }
            .note-top { top: 47px; right: 1px; }
            .note-bottom { bottom: 43px; left: 0; }
            .section-heading { align-items: start; flex-direction: column; }
            .steps { grid-template-columns: 1fr; }
            .step-card { min-height: auto; }
            .step-number { margin-bottom: 18px; }
            .site-footer { align-items: start; flex-direction: column; gap: 10px; }
        }

        @media (max-width: 390px) {
            .page-shell { width: calc(100% - 28px); }
            .nav-links { gap: 10px; font-size: 13px; }
            .hero-art { min-height: 330px; }
            .item-card { width: 235px; }
            .item-art { height: 198px; }
            .float-note { padding: 9px 11px; font-size: 11px; }
            .note-top { top: 35px; }
            .note-bottom { bottom: 31px; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { transition-duration: 0.01ms !important; }
        }
    </style>
</head>

<body>
    <header class="page-shell site-header">
        <a class="brand" href="/" aria-label="Circlo home">
            <span class="brand-mark" aria-hidden="true">c</span>
            <span>circlo</span>
        </a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="#how-it-works">How it works</a>
            <a class="text-link" href="{{ url('/login') }}">Log in</a>
            <a class="button" href="{{ url('/login') }}">Join Circlo <span aria-hidden="true">&nbsp;↗</span></a>
        </nav>
    </header>

    <main>
        <section class="page-shell hero" aria-labelledby="hero-title">
            <div class="hero-content">
                <p class="eyebrow">Good things go around</p>
                <h1 id="hero-title">A little more <span>sharing.</span><br>A lot more living.</h1>
                <p class="hero-copy">
                    The things we need are already close by. Borrow from your neighbors, share what you have, and make
                    your community feel a little closer.
                </p>
                <div class="hero-actions">
                    <a class="button" href="{{ url('/login') }}">Find your circle <span aria-hidden="true">&nbsp;↗</span></a>
                    <a class="button button-light" href="#how-it-works">See how it works</a>
                </div>
                <div class="hero-note">
                    <div class="avatars" aria-hidden="true">
                        <span class="avatar">JM</span>
                        <span class="avatar">AL</span>
                        <span class="avatar">SK</span>
                    </div>
                    <span>Made for neighbors, by neighbors.</span>
                </div>
            </div>

            <div class="hero-art" aria-label="A Circlo member sharing a drill with a neighbor">
                <div class="art-orbit" aria-hidden="true"></div>
                <div class="float-note note-top"><span aria-hidden="true">↗</span>Shared nearby</div>
                <article class="item-card">
                    <div class="item-art">
                        <svg viewBox="0 0 260 250" role="img" aria-label="Illustration of a cordless drill">
                            <path d="M32 211c25-26 52-38 98-38s73 12 98 38v39H32z" fill="#b9c9a5"/>
                            <circle cx="128" cy="127" r="82" fill="#cbd7bb"/>
                            <path d="M70 101h94a22 22 0 0 1 22 22v20a22 22 0 0 1-22 22h-16l-4 38a10 10 0 0 1-10 9h-28a10 10 0 0 1-10-10v-37H70a14 14 0 0 1-14-14v-36a14 14 0 0 1 14-14z" fill="#f3b35c"/>
                            <path d="M186 112h31a8 8 0 0 1 8 8v27a8 8 0 0 1-8 8h-31z" fill="#536859"/>
                            <path d="M225 120h20v27h-20z" fill="#d5ddcf"/>
                            <path d="M246 126h10v15h-10z" fill="#7b897b"/>
                            <path d="M108 101V83a14 14 0 0 1 14-14h26a14 14 0 0 1 14 14v18" fill="none" stroke="#536859" stroke-width="10" stroke-linecap="round"/>
                            <path d="M111 178h34v27a7 7 0 0 1-7 7h-20a7 7 0 0 1-7-7z" fill="#536859"/>
                            <circle cx="84" cy="130" r="5" fill="#fff5df"/>
                            <path d="M73 151h17" stroke="#df9450" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="item-details">
                        <div>
                            <strong>Weekend drill</strong>
                            <small>Shared by Jamie · 2 streets away</small>
                        </div>
                        <span class="item-tag">Free to borrow</span>
                    </div>
                </article>
                <div class="float-note note-bottom"><span aria-hidden="true">♡</span>Less buying, more belonging</div>
            </div>
        </section>

        <section class="page-shell how-section" id="how-it-works" aria-labelledby="how-title">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">A better kind of everyday</p>
                    <h2 id="how-title">Good neighbors make<br>good things happen.</h2>
                </div>
                <p class="section-intro">
                    Circlo helps your neighborhood make the most of what it already has — one useful little exchange at a time.
                </p>
            </div>
            <div class="steps">
                <article class="step-card">
                    <span class="step-number">01</span>
                    <h3>Find what you need</h3>
                    <p>Browse useful things shared by people right around the corner.</p>
                </article>
                <article class="step-card">
                    <span class="step-number">02</span>
                    <h3>Ask, borrow, enjoy</h3>
                    <p>Connect with your neighbor and make a plan that works for you both.</p>
                </article>
                <article class="step-card">
                    <span class="step-number">03</span>
                    <h3>Pass the good on</h3>
                    <p>Return the favor, share something of your own, and keep the circle going.</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="page-shell site-footer">
        <a class="footer-brand" href="/">circlo</a>
        <span>Borrow. Share. Make it count.</span>
        <span>Better together, right where you are.</span>
    </footer>
</body>

</html>
