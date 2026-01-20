<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'LMS AI') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    {{-- Apni existing CSS bundle --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">

    <style>
        :root {
            --bg: #f5f7ff;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e9ecf5;
            --purple: #6777ef;
            --purple2: #7c3aed;
            --shadow: 0 14px 40px rgba(17, 24, 39, .08);
            --shadow2: 0 10px 25px rgba(103, 119, 239, .18);
            --radius: 16px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background:
                radial-gradient(900px 380px at 10% 0%, rgba(103, 119, 239, .18), transparent 65%),
                radial-gradient(900px 380px at 90% 5%, rgba(124, 58, 237, .10), transparent 65%),
                var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ---------- NAV ---------- */
        .nav-wrap {
            position: sticky;
            top: 0;
            z-index: 60;
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }

        .container-x {
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            letter-spacing: .2px;
            color: var(--text);
            text-decoration: none;
        }

        .brand-badge {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            box-shadow: var(--shadow2);
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 700;
            margin: 0 10px;
            padding: 10px 10px;
            border-radius: 10px;
            transition: .2s ease;
            display: inline-flex;
            align-items: center;
        }

        .nav-links a:hover {
            color: var(--text);
            background: rgba(103, 119, 239, .08);
        }

        .btnx {
            border-radius: 12px;
            padding: 10px 14px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
            border: 1px solid var(--line);
            gap: 8px;
            white-space: nowrap;
        }

        .btnx.ghost {
            background: #fff;
            color: var(--purple);
        }

        .btnx.ghost:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btnx.primary {
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            color: #fff;
            border-color: rgba(103, 119, 239, .25);
            box-shadow: var(--shadow2);
        }

        .btnx.primary:hover {
            transform: translateY(-1px);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-inner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
        }

        .nav-center {
            display: flex;
            justify-content: center;
            gap: 22px;
        }

        .nav-center a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 700;
            padding: 8px 10px;
            border-radius: 8px;
            transition: .2s ease;
        }

        .nav-center a:hover {
            color: var(--purple);
            background: rgba(103, 119, 239, .08);
        }

        .brand-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }


        /* ---------- HERO ---------- */
        .section {
            padding: 70px 0;
        }

        .hero {
            padding: 70px 0 40px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 999px;
            font-weight: 800;
            color: var(--purple);
            box-shadow: 0 10px 20px rgba(17, 24, 39, .05);
        }

        .h1 {
            font-weight: 700;
            font-size: 44px;
            line-height: 1.1;
            margin: 14px 0 12px;
        }

        .sub {
            color: var(--muted);
            font-size: 16px;
            max-width: 540px;
        }

        .hero-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .hero-img {
            width: 100%;
            border-radius: 14px;
            border: 1px solid var(--line);
            box-shadow: 0 18px 45px rgba(17, 24, 39, .10);
            display: block;
        }

        /* ---------- HEADINGS ---------- */
        .sec-title {
            font-weight: 900;
            font-size: 30px;
            margin: 0;
        }

        .sec-sub {
            color: var(--muted);
            margin: 8px 0 0;
            font-weight: 600;
        }

        .title-row {
            margin-bottom: 22px;
        }

        /* ---------- CARDS / GRID ---------- */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .cardx {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 18px;
            transition: .2s ease;
            height: 100%;
        }

        .cardx:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 55px rgba(17, 24, 39, .12);
        }

        .icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(103, 119, 239, .12);
            color: var(--purple);
            font-weight: 900;
            margin-bottom: 10px;
        }

        .cardx h5 {
            margin: 0 0 6px;
            font-weight: 900;
        }

        .cardx p {
            margin: 0;
            color: var(--muted);
            font-weight: 600;
        }

        /* ---------- MODULE CHIPS ---------- */
        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .chip {
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 999px;
            padding: 10px 12px;
            font-weight: 800;
            color: var(--text);
            box-shadow: 0 10px 22px rgba(17, 24, 39, .05);
        }

        .chip b {
            color: var(--purple);
        }

        /* ---------- TESTIMONIALS ---------- */
        .quote {
            font-size: 14px;
            color: var(--muted);
            font-weight: 600;
            line-height: 1.6;
        }

        .person {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            box-shadow: var(--shadow2);
        }

        .person b {
            display: block;
        }

        .person small {
            color: var(--muted);
            font-weight: 700;
        }

        /* ---------- CONTACT ---------- */
        .formx input,
        .formx textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px 12px;
            outline: none;
            background: #fff;
            font-weight: 700;
        }

        .formx input:focus,
        .formx textarea:focus {
            border-color: rgba(103, 119, 239, .55);
            box-shadow: 0 0 0 4px rgba(103, 119, 239, .12);
        }

        .formx label {
            font-weight: 900;
            margin-bottom: 6px;
            display: block;
            color: var(--text);
        }

        /* ---------- FOOTER ---------- */
        .footer {
            border-top: 1px solid var(--line);
            padding: 28px 0;
            background: rgba(255, 255, 255, .65);
        }

        .footer a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 800;
        }

        .footer a:hover {
            color: var(--purple);
        }

        /* ---------- ANIMATIONS (Scroll reveal) ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(14px);
            transition: .7s ease;
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-1 {
            transition-delay: .12s;
        }

        .delay-2 {
            transition-delay: .22s;
        }

        .delay-3 {
            transition-delay: .32s;
        }

        /* ---------- RESPONSIVE ---------- */
        .hamburger {
            display: none;
        }

        @media (max-width: 992px) {
            .h1 {
                font-size: 36px;
            }

            .nav-links {
                display: none;
            }

            .grid-3 {
                grid-template-columns: 1fr;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }

            .hero {
                padding-top: 52px;
            }

            .hamburger {
                display: inline-flex;
            }
        }

        @media (max-width: 992px) {

            .nav-center {
                display: none;
            }

            .hero .grid-2 {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero img {
                margin-top: 30px;
            }

            .hero .btnx {
                width: 100%;
                justify-content: center;
            }

            .grid-3,
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .footer {
                text-align: center;
            }
        }

        /* ---------- NAV (PRO) ---------- */
        .nav-pro {
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .nav-pro .navbar {
            gap: 14px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .brand-name {
            font-weight: 900;
            letter-spacing: .2px;
            font-size: 18px;
        }

        .brand-tagline {
            color: var(--muted);
            font-weight: 700;
            font-size: 12px;
            margin-top: 2px;
        }

        /* center menu look */
        .nav-pills-center {
            gap: 6px;
        }

        .nav-pills-center .nav-link {
            position: relative;
            color: var(--muted);
            font-weight: 800;
            padding: 10px 12px;
            border-radius: 12px;
            transition: .2s ease;
        }

        .nav-pills-center .nav-link:hover {
            color: var(--text);
            background: rgba(103, 119, 239, .08);
            transform: translateY(-1px);
        }

        .nav-pills-center .nav-link::after {
            content: "";
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 6px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            opacity: 0;
            transform: scaleX(.6);
            transition: .18s ease;
        }

        .nav-pills-center .nav-link:hover::after {
            opacity: 1;
            transform: scaleX(1);
        }

        /* toggler pro */
        .nav-toggler {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 12px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(17, 24, 39, .06);
        }

        .nav-toggler:focus {
            box-shadow: 0 0 0 4px rgba(103, 119, 239, .18);
        }

        .nav-toggler .toggler-line {
            display: block;
            width: 20px;
            height: 2px;
            background: #374151;
            border-radius: 999px;
            margin: 4px 0;
        }

        /* make right buttons align nicely */
        .nav-actions {
            white-space: nowrap;
        }

        /* mobile collapse: looks like dropdown card */
        @media (max-width: 992px) {
            .brand-tagline {
                display: none;
            }

            #mainNav {
                margin-top: 12px;
                background: rgba(255, 255, 255, .92);
                border: 1px solid var(--line);
                border-radius: 16px;
                padding: 10px;
                box-shadow: var(--shadow);
            }

            .nav-pills-center {
                gap: 0;
            }

            .nav-pills-center .nav-link {
                padding: 12px 12px;
                border-radius: 12px;
            }

            .nav-actions {
                margin-top: 10px;
                width: 100%;
                justify-content: stretch;
            }

            .nav-actions .btnx {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

@php
    // safe urls (register missing issue avoid)
    $loginUrl = route('login');
    $accountUrl = route('login'); // later: route('register')
@endphp

<body>

    {{-- HEADER --}}
    <div class="nav-wrap">
        <div class="container-x">

            <nav class="navbar navbar-expand-lg">
                <!-- LOGO -->
                <a class="navbar-brand brand" href="{{ route('index') }}">
                    <span class="brand-badge">💻</span>
                    <span>LMS‑AI</span>
                </a>

                <!-- MOBILE TOGGLE -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    ☰
                </button>

                <!-- MENU -->
                <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                    <ul class="navbar-nav gap-2" id="navLinks">
                        <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#modules">Modules</a></li>
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                </div>

                <!-- RIGHT BUTTONS -->
                <div class="d-flex gap-2">
                    <a class="btnx ghost" href="{{ route('login') }}">Login</a>
                    <a class="btnx primary" href="{{ route('login') }}">Account</a>
                </div>
            </nav>

        </div>
    </div>


    {{-- HERO --}}
    <section id="home" class="hero">
        <div class="container-x">
            <div class="grid-2" style="align-items:center;">

                <!-- LEFT CONTENT -->
                <div class="reveal show">

                    <span class="pill">✨ Smart LMS Platform</span>

                    <h1 class="h1">
                        All‑in‑One L.M.S for <br>
                        <span style="color:var(--purple)">Admins, Trainers & Students</span>
                    </h1>

                    <p class="sub">
                        Manage courses, generate AI‑powered quizzes, track performance,
                        and monitor student progress — all from a clean, modern dashboard.
                    </p>

                    <div style="display:flex; gap:12px; margin-top:20px;">
                        <a class="btnx primary" href="{{ route('login') }}">
                            Get Started
                        </a>
                        <a class="btnx ghost" href="#features">
                            Explore Features
                        </a>
                    </div>

                    <!-- MINI STATS -->
                    <div class="hero-card" style="margin-top:28px;">
                        <div class="grid-3">
                            <div>
                                <b style="color:var(--purple); font-size:18px;">AI Quizzes</b>
                                <div class="sub">Auto MCQ Generation</div>
                            </div>
                            <div>
                                <b style="color:var(--purple); font-size:18px;">Dashboards</b>
                                <div class="sub">Role‑based Analytics</div>
                            </div>
                            <div>
                                <b style="color:var(--purple); font-size:18px;">Tracking</b>
                                <div class="sub">Progress & Reports</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="reveal delay-1">
                    <img class="hero-img"
                        src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=1400&q=80"
                        alt="LMS Dashboard">
                </div>

            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="section">
        <div class="container-x">
            <div class="title-row reveal">
                <h2 class="sec-title">About</h2>
                <p class="sec-sub">A clean learning portal built for modern training, assignments and AI‑powered
                    assessments.</p>
            </div>

            <div class="grid-3">
                <div class="cardx reveal">
                    <div class="icon">A</div>
                    <h5>Admin Control</h5>
                    <p>Users, courses, analytics — complete platform control in one place.</p>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="icon">T</div>
                    <h5>Trainer Workflow</h5>
                    <p>Course create, quizzes generate, student progress — fast & organized.</p>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="icon">S</div>
                    <h5>Student Experience</h5>
                    <p>Enrollments, attempts, feedback — everything simple & user‑friendly.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- MODULES --}}
    <section id="modules" class="section" style="padding-top:10px;">
        <div class="container-x">
            <div class="title-row reveal">
                <h2 class="sec-title">Modules</h2>
                <p class="sec-sub">Portal ke core modules — clear, scalable and easy to use.</p>
            </div>

            <div class="cardx reveal">
                <div class="chips">
                    <div class="chip"><b>01</b> User Management</div>
                    <div class="chip"><b>02</b> Course Management</div>
                    <div class="chip"><b>03</b> Enrollments</div>
                    <div class="chip"><b>04</b> AI Quiz Generator</div>
                    <div class="chip"><b>05</b> Quizzes & Questions</div>
                    <div class="chip"><b>06</b> Progress Tracking</div>
                    <div class="chip"><b>07</b> Feedback System</div>
                    <div class="chip"><b>08</b> Role Dashboards</div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section id="features" class="section" style="padding-top:10px;">
        <div class="container-x">
            <div class="title-row reveal">
                <h2 class="sec-title">Features</h2>
                <p class="sec-sub">White & purple theme, clean UI, and interactive experience.</p>
            </div>

            <div class="grid-3">
                <div class="cardx reveal">
                    <div class="icon">⚡</div>
                    <h5>Fast Dashboard</h5>
                    <p>Quick overview cards and clean charts for activity & insights.</p>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="icon">🧠</div>
                    <h5>AI Quiz Generation</h5>
                    <p>Topic se MCQs generate, select max 10 and save instantly.</p>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="icon">🔒</div>
                    <h5>Role Based Access</h5>
                    <p>Admin / Trainer / Student — har role ka apna portal view.</p>
                </div>

                <div class="cardx reveal">
                    <div class="icon">📈</div>
                    <h5>Reports</h5>
                    <p>Enrollments, attempts and trends — monthly analytics support.</p>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="icon">🧩</div>
                    <h5>Modular</h5>
                    <p>Easy to extend: certificates, payments, exams, sections etc.</p>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="icon">💬</div>
                    <h5>Feedback</h5>
                    <p>Students feedback, trainer actions, admin visibility — organized flow.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section id="testimonials" class="section" style="padding-top:10px;">
        <div class="container-x">
            <div class="title-row reveal">
                <h2 class="sec-title">Testimonials</h2>
                <p class="sec-sub">A few words from users who used the portal.</p>
            </div>

            <div class="grid-3">
                <div class="cardx reveal">
                    <div class="quote">“UI clean hai aur dashboard se sab cheez jaldi samajh aa jati hai. Quizzes
                        generate karna bohat easy.”</div>
                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Trainer</b>
                            <small>Course Creator</small>
                        </div>
                    </div>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="quote">“Enrollments & quizzes ka flow smooth hai. Progress track karna helpful hai.”
                    </div>
                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Student</b>
                            <small>Learner</small>
                        </div>
                    </div>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="quote">“Admin management aur analytics modules best hain. Role based access ne system
                        secure banaya.”</div>
                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Admin</b>
                            <small>Platform Manager</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT --}}
    <section id="contact" class="section" style="padding-top:10px;">
        <div class="container-x">
            <div class="title-row reveal">
                <h2 class="sec-title">Contact</h2>
                <p class="sec-sub">Need help? Send a message — we’ll get back to you.</p>
            </div>

            <div class="grid-2">
                <div class="cardx reveal">
                    <h5 style="font-weight:900; margin:0 0 8px;">Get in touch</h5>
                    <p style="color:var(--muted); font-weight:700; margin:0;">
                        Email, phone ya form — jo easy ho. (Form demo UI hai, backend connect baad me.)
                    </p>

                    <div class="mt-3" style="display:grid; gap:10px;">
                        <div class="cardx" style="box-shadow:none; border-radius:14px;">
                            <b style="color:var(--purple);">Email</b>
                            <div style="color:var(--muted); font-weight:800;">support@yourdomain.com</div>
                        </div>
                        <div class="cardx" style="box-shadow:none; border-radius:14px;">
                            <b style="color:var(--purple);">Phone</b>
                            <div style="color:var(--muted); font-weight:800;">+92 300 0000000</div>
                        </div>
                    </div>
                </div>

                <div class="cardx reveal delay-1">
                    <form class="formx"
                        onsubmit="event.preventDefault(); alert('Demo form. Backend baad me connect kar dena.');">
                        <div style="display:grid; gap:12px;">
                            <div>
                                <label>Name</label>
                                <input type="text" placeholder="Your name" required />
                            </div>
                            <div>
                                <label>Email</label>
                                <input type="email" placeholder="you@example.com" required />
                            </div>
                            <div>
                                <label>Message</label>
                                <textarea rows="5" placeholder="Write your message..." required></textarea>
                            </div>

                            <button class="btnx primary" type="submit" style="width:fit-content;">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="container-x"
            style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
            <div style="font-weight:900;">
                © {{ date('Y') }} {{ config('app.name', 'LMS AI') }}
                <span style="color:var(--muted); font-weight:800;">— All rights reserved.</span>
            </div>

            <div style="display:flex; gap:14px;">
                <a href="#about">About</a>
                <a href="#features">Features</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Scroll reveal JS (smooth animation effects) --}}
    <script>
        const els = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('show');
            });
        }, { threshold: 0.15 });

        els.forEach(el => io.observe(el));

        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll("section[id]");
            const navLinks = document.querySelectorAll(".nav-link");

            function activateMenu() {
                let scrollY = window.scrollY + 120;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const id = section.getAttribute("id");

                    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                        navLinks.forEach(link => link.classList.remove("active"));
                        const activeLink = document.querySelector(`.nav-link[href="#${id}"]`);
                        if (activeLink) activeLink.classList.add("active");
                    }
                });
            }

            window.addEventListener("scroll", activateMenu);
            activateMenu(); // page load par bhi
        });
    </script>

</body>

</html>