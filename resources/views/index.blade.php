<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LMS-AI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">


    {{-- Apni existing CSS bundle --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/style.css') }}">

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

                    <span class="pill">Smart L.M.S</span>

                    <h1 class="h1">
                        All‑in‑One<br>
                        <span style="color:var(--purple)">Learning Solution</span>
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
    <section id="about" class="section" style="padding-top:60px;">
        <div class="container-x">

            <!-- Heading -->
            <div class="text-center mb-5 reveal">
                <h2 class="sec-title">About Us</h2>
                <div style="width:60px;height:4px;background:var(--purple);margin:10px auto;border-radius:10px;"></div>
                <p class="sec-sub mt-2">
                    Helping institutions grow with modern learning technology
                </p>
            </div>

            <div class="row align-items-center g-5">

                <!-- LEFT CONTENT -->
                <div class="col-lg-6 reveal">

                    <span class="pill mb-3">🚀 Smart LMS Platform</span>

                    <h3 style="font-weight:900;margin-top:12px;">
                        Helping organizations succeed with
                        <span style="color:var(--purple)">AI‑powered learning</span>
                    </h3>

                    <p class="sec-sub mt-3" style="max-width:520px;">
                        LMS‑AI helps institutes manage courses, automate assessments,
                        track learner progress and deliver a modern digital learning experience.
                    </p>

                    <div class="mt-4 d-grid gap-3">

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">⚙️</div>
                            <div>
                                <h6 class="mb-1 fw-bold">Smart Management</h6>
                                <p class="sub">Manage users, roles and courses with ease.</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">📊</div>
                            <div>
                                <h6 class="mb-1 fw-bold">Analytics & Tracking</h6>
                                <p class="sub">Monitor performance with real‑time insights.</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">🧠</div>
                            <div>
                                <h6 class="mb-1 fw-bold">AI Powered Learning</h6>
                                <p class="sub">Auto generate quizzes & assessments instantly.</p>
                            </div>
                        </div>

                    </div>

                    <a href="#features" class="btnx primary mt-4">
                        Explore Features
                    </a>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="col-lg-6 reveal delay-1 position-relative">

                    <img src="https://miro.medium.com/v2/1*k3OU519iKbNHycQXdiRraw.jpeg" class="hero-img"
                        alt="About LMS">

                    <!-- Decorative Shape -->
                    <div style="
                    position:absolute;
                    bottom:-25px;
                    right:-25px;
                    width:130px;
                    height:130px;
                    background:linear-gradient(135deg,var(--purple),var(--purple2));
                    border-radius:50%;
                    opacity:.15;">
                    </div>
                </div>

            </div>
        </div>
    </section>



    {{-- MODULES --}}
    <section id="modules" class="section modules-wrap" style="padding-top:10px;">
        <div class="container-x">
            <div class="modules-head text-center reveal">
                <h2 class="sec-title">Modules</h2>
                <div class="underline"></div>
                <p class="sec-sub mt-3">
                    Choose the module set that matches your role — designed like a modern courses platform.
                </p>
            </div>

            <div class="row g-4 mt-2">
                {{-- Card 1 --}}
                <div class="col-12 col-md-6 col-lg-4 reveal">
                    <div class="module-card p-4">
                        <div class="module-icon">
                            <span>🎓</span>
                        </div>

                        <h4 class="module-title text-center">Student</h4>
                        <p class="module-desc text-center">
                            Learn faster with a clean dashboard, enrollments, and quiz attempts.
                        </p>

                        <ul class="module-list mt-3">
                            <li><span class="tick">✓</span> Course enrollments & access</li>
                            <li><span class="tick">✓</span> Quiz attempts & results</li>
                            <li><span class="tick">✓</span> Progress tracking & feedback</li>
                        </ul>

                        <div class="mt-4">
                            <a href="#features" class="btn module-btn btn-outline-purple">Explore as Student</a>
                        </div>
                    </div>
                </div>

                {{-- Card 2 (Featured) --}}
                <div class="col-12 col-md-6 col-lg-4 reveal delay-1">
                    <div class="module-card featured p-4">
                        <div class="module-badge">Most Popular</div>

                        <div class="module-icon">
                            <span>🧑‍🏫</span>
                        </div>

                        <h4 class="module-title text-center">Trainer</h4>
                        <p class="module-desc text-center">
                            Create courses, generate AI quizzes, and manage student learning flow.
                        </p>

                        <ul class="module-list mt-3">
                            <li><span class="tick">✓</span> Course creation & management</li>
                            <li><span class="tick">✓</span> AI quiz generator & question bank</li>
                            <li><span class="tick">✓</span> Student insights & performance</li>
                        </ul>

                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn module-btn btn-purple">Explore as Trainer</a>
                        </div>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="col-12 col-md-6 col-lg-4 reveal delay-2">
                    <div class="module-card p-4">
                        <div class="module-icon">
                            <span>🛡️</span>
                        </div>

                        <h4 class="module-title text-center">Admin</h4>
                        <p class="module-desc text-center">
                            Full control: users, roles, courses, analytics, and platform settings.
                        </p>

                        <ul class="module-list mt-3">
                            <li><span class="tick">✓</span> Users & role management</li>
                            <li><span class="tick">✓</span> System analytics & reports</li>
                            <li><span class="tick">✓</span> Platform monitoring & control</li>
                        </ul>

                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn module-btn btn-outline-purple">Explore as
                                Admin</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- FEATURES --}}
    <section id="features" class="section" style="padding-top:10px;">
        <div class="container-x">

            <!-- SECTION HEADER -->

            <div class="modules-head text-center reveal" style="margin-bottom:40px;">
                <h2 class="sec-title">Features</h2>
                <div class="underline"></div>
                <p class="sec-sub mt-3" style="max-width:700px;margin:0 auto;">
                    Everything you need to manage courses, generate quizzes,
                    and track progress — designed with performance and simplicity in mind.
                </p>
            </div>

            <!-- FEATURES GRID -->
            <div class="grid-3">
                <div class="cardx reveal">
                    <div class="icon">⚡</div>
                    <h5>Fast Dashboard</h5>
                    <p>Quick overview cards and clean charts for activity & insights.</p>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="icon">🧠</div>
                    <h5>AI Quiz Generation</h5>
                    <p>Generate MCQs instantly from topics with smart AI logic.</p>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="icon">🔒</div>
                    <h5>Role Based Access</h5>
                    <p>Admin, Trainer & Student — secure access for each role.</p>
                </div>

                <div class="cardx reveal">
                    <div class="icon">📈</div>
                    <h5>Reports & Analytics</h5>
                    <p>Track enrollments, attempts and performance trends.</p>
                </div>

                <div class="cardx reveal delay-1">
                    <div class="icon">🧩</div>
                    <h5>Modular System</h5>
                    <p>Easily extend with certificates, exams & more modules.</p>
                </div>

                <div class="cardx reveal delay-2">
                    <div class="icon">💬</div>
                    <h5>Feedback System</h5>
                    <p>Students & trainers can share feedback seamlessly.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section id="testimonials" class="section" style="padding-top:10px;">
        <div class="container-x">

            <!-- Section Heading -->
            <div class="modules-head text-center reveal" style="margin-bottom:40px;">
                <h2 class="sec-title">Testimonials</h2>
                <div class="underline"></div>
                <p class="sec-sub mt-3" style="max-width:700px;margin:0 auto;">
                    Trusted by admins, trainers and students using LMS‑AI daily.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid-3">

                <!-- Card 1 -->
                <div class="cardx reveal">
                    <div class="icon">🎓</div>

                    <p class="quote">
                        “The dashboard is very clean and easy to use. Creating quizzes
                        and managing students has become super smooth.”
                    </p>

                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Ahmed Khan</b>
                            <small>Trainer</small>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="cardx reveal delay-1">
                    <div class="icon">📘</div>

                    <p class="quote">
                        “I like how everything is organized. Course access, quizzes,
                        and progress tracking are very clear.”
                    </p>

                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Fatima Noor</b>
                            <small>Student</small>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="cardx reveal delay-2">
                    <div class="icon">🛡️</div>

                    <p class="quote">
                        “Role-based access and analytics make management easy.
                        Perfect LMS for institutions.”
                    </p>

                    <div class="person">
                        <div class="avatar"></div>
                        <div>
                            <b>Usman Ali</b>
                            <small>Admin</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CONTACT --}}
    <section id="contact" class="section" style="padding-top:10px;">
        <div class="container-x">

            <!-- Section Heading -->
            <div class="modules-head text-center reveal" style="margin-bottom:40px;">
                <h2 class="sec-title">Contact</h2>
                <div class="underline"></div>
                <p class="sec-sub mt-3" style="max-width:700px;margin:0 auto;">
                    Have a question or need help? Our team is here to assist you.
                </p>
            </div>

            <div class="grid-2 align-items-center">

                <!-- LEFT INFO -->
                <div class="reveal">
                    <h3 style="font-weight:900;margin-bottom:10px;">
                        Let’s talk about <span style="color:var(--purple2">Lms-AI</span>
                    </h3>

                    <p class="sub" style="max-width:500px;">
                        Whether you need support, demo access, or feature clarification —
                        feel free to contact us anytime.
                    </p>

                    <div style="margin-top:25px; display:grid; gap:16px;">

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">📧</div>
                            <div>
                                <b>Email</b>
                                <div class="sub">support@lms-ai.com</div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">📞</div>
                            <div>
                                <b>Phone</b>
                                <div class="sub">+92 332 6093660</div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon">📍</div>
                            <div>
                                <b>Office</b>
                                <div class="sub">Aptech Metro Star Gate</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT FORM -->
                <div class="cardx reveal delay-1">
                    @if(session('success'))
                        <div class="auth-success" id="successBox">
                            <span class="msg">✅ {{ session('success') }}</span>
                            <button type="button" class="close-btn" onclick="closeAlert()">×</button>
                        </div>
                    @endif
                    <form class="formx" method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        <div style="display:grid; gap:14px;">

                            <div>
                                <label>Name</label>
                                <input type="text" placeholder="Your name" required pattern="[a-zA-Z ]{3,30}"
                                    name="name">
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" placeholder="you@example.com" required name="email">
                            </div>

                            <div>
                                <label>Message</label>
                                <textarea name="message" rows="5" maxlength="300" placeholder="Write your message..."
                                    required oninput="updateCounter(this)"></textarea>

                                <small id="charCount" style="color:#888;">0 / 300</small>

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
                © {{ date('Y') }} LMS-AI
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

        function closeAlert() {
            const el = document.getElementById('successBox');
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-5px)';
                setTimeout(() => el.remove(), 250);
            }
        }
        function updateCounter(el) {
            const max = el.getAttribute("maxlength");
            const current = el.value.length;
            document.getElementById("charCount").innerText =
                `${current} / ${max}`;
        }
    </script>

</body>

</html>