<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>

    {{-- Your existing CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    {{-- Optional (nice typography) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7ff;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --purple: #5b6bff;
            --purple2: #7c3aed;
            --line: #e6e9f2;
            --radius: 18px;
            --shadow: 0 20px 45px rgba(17, 24, 39, .12);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background:
                radial-gradient(900px 420px at 20% 10%, rgba(124, 58, 237, .15), transparent 60%),
                radial-gradient(900px 420px at 85% 35%, rgba(91, 107, 255, .15), transparent 60%),
                var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* MAIN */
        .auth-shell {
            width: 1100px;
            max-width: 100%;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: #fff;
        }

        .auth-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 620px;
        }

        /* LEFT */
        .auth-left {
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            color: #fff;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }

        .left-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .left-item {
            display: flex;
            gap: 14px;
            margin-bottom: 16px;
        }

        .left-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-item h6 {
            margin: 0;
            font-weight: 800;
        }

        .left-item p {
            margin: 3px 0 0;
            font-size: 13px;
            opacity: .9;
        }

        /* RIGHT */
        .auth-right {
            background: #fff;
            padding: 60px;
            display: flex;
            align-items: center;
        }

        .form-wrap {
            width: 100%;
        }

        .welcome {
            font-size: 28px;
            font-weight: 800;
        }

        .welcome-sub {
            color: var(--muted);
            margin-bottom: 25px;
        }

        .field-label {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .inputx {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
        }

        .inputx input {
            border: none;
            outline: none;
            width: 100%;
            font-weight: 600;
        }

        .btn-login {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            border: none;
            color: #fff;
            font-weight: 800;
        }

        .bottom-links {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
        }

        .bottom-links a {
            color: var(--purple);
            font-weight: 700;
            text-decoration: none;
        }

        /* Responsive */
        @media(max-width:992px) {
            .auth-row {
                grid-template-columns: 1fr;
            }

            .auth-left {
                text-align: center;
            }
        }

        button,
        button:focus,
        button:active {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .toggle-pass {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent;
        }
    </style>

</head>

<body>

    <div class="auth-shell">
        <div class="auth-row">

            <!-- LEFT -->
            <div class="auth-left">
                <div class="brand">
                    <div class="brand-badge">💻</div>
                    <div>
                        <b>LMS‑AI</b><br>
                        <small>Smart Learning Portal</small>
                    </div>
                </div>

                <div class="left-title">Why choose LMS‑AI?</div>

                <div class="left-item">
                    <div class="left-icon">🧠</div>
                    <div>
                        <h6>AI Based Learning</h6>
                        <p>Smart quizzes & evaluations</p>
                    </div>
                </div>

                <div class="left-item">
                    <div class="left-icon">📊</div>
                    <div>
                        <h6>Progress Tracking</h6>
                        <p>Monitor performance easily</p>
                    </div>
                </div>

                <div class="left-item">
                    <div class="left-icon">⚡</div>
                    <div>
                        <h6>Fast & Secure</h6>
                        <p>Optimized for institutions</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="auth-right">
                <div class="form-wrap">

                    <h2 class="welcome">Welcome Back</h2>
                    <p class="welcome-sub">Login to your dashboard</p>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <label class="field-label">Email</label>
                        <div class="inputx mb-3">
                            <input type="email" name="email" placeholder="Enter email" required>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Password</label>

                            <div class="inputx">
                                <input id="password" type="password" name="password" placeholder="Enter your password"
                                    required>

                                <button type="button" class="toggle-pass" onclick="togglePassword()"
                                    aria-label="Toggle password">
                                    👁️
                                </button>
                            </div>
                        </div>


                        <button class="btn-login">Login</button>

                        <div class="bottom-links">
                            <p>
                                Don’t have an account?
                                <a href="{{ route('register') }}">Create Account</a>
                            </p>
                            <a href="{{ route('index') }}">← Back to Home</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>


    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const btn = event.currentTarget;

            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "🙈";
            } else {
                input.type = "password";
                btn.textContent = "👁️";
            }
        }
    </script>


</body>

</html>