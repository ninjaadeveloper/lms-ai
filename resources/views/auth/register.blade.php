<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>

    {{-- Your existing CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    {{-- Montserrat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7ff;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e9ecf5;
            --purple: #6777ef;
            --purple2: #7c3aed;
            --shadow: 0 28px 70px rgba(17, 24, 39, .16);
            --radius: 18px;
        }

        body {
            font-family: 'Montserrat', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            min-height: 100vh;
            background:
                radial-gradient(900px 420px at 20% 10%, rgba(124, 58, 237, .18), transparent 60%),
                radial-gradient(900px 420px at 85% 35%, rgba(103, 119, 239, .18), transparent 60%),
                var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 26px 14px;
        }

        /* Main shell */
        .auth-shell {
            width: min(1100px, 100%);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid rgba(103, 119, 239, .12);
            background: rgba(255, 255, 255, .35);
        }

        .auth-row {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            min-height: 640px;
            background: #fff;
        }

        /* Left panel */
        .auth-left {
            position: relative;
            padding: 46px 48px;
            background: linear-gradient(135deg, rgba(103, 119, 239, .98), rgba(124, 58, 237, .98));
            color: #fff;
            display: flex;
            /* vertical center */
            align-items: center;
            /* vertical center */
        }

        .auth-left::before {
            content: "";
            position: absolute;
            inset: -120px auto auto -120px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .18);
        }

        .auth-left::after {
            content: "";
            position: absolute;
            right: -140px;
            bottom: -140px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
        }

        .left-inner {
            position: relative;
            width: 100%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 34px;
            user-select: none;
        }

        .brand-badge {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            letter-spacing: .4px;
        }

        .brand-name {
            font-weight: 800;
            font-size: 18px;
            margin: 0;
            line-height: 1.1;
        }

        .brand-sub {
            margin: 0;
            opacity: .9;
            font-weight: 600;
            font-size: 12px;
        }

        .left-title {
            font-weight: 800;
            font-size: 34px;
            line-height: 1.15;
            margin: 0 0 18px;
        }

        .left-sub {
            margin: 0 0 22px;
            opacity: .92;
            font-weight: 600;
            line-height: 1.6;
            max-width: 420px;
        }

        .left-list {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        .left-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .left-icon {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 44px;
            font-size: 18px;
        }

        .left-item h6 {
            margin: 0;
            font-weight: 800;
            font-size: 15px;
        }

        .left-item p {
            margin: 3px 0 0;
            opacity: .92;
            font-weight: 600;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Right panel (white) */
        .auth-right {
            background: #ffffff;
            padding: 46px 48px;
            display: flex;
            align-items: center;
        }

        .form-wrap {
            width: 100%;
        }

        .welcome {
            font-weight: 800;
            margin: 0 0 6px;
            font-size: 32px;
            letter-spacing: .2px;
        }

        .welcome-sub {
            margin: 0 0 26px;
            color: var(--muted);
            font-weight: 600;
            line-height: 1.5;
        }

        .field-label {
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .inputx {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #e7ecf5;
            background: #fff;
            border-radius: 14px;
            padding: 12px 14px;
            transition: .18s ease;
        }

        .inputx:focus-within {
            border-color: rgba(103, 119, 239, .55);
            box-shadow: 0 0 0 4px rgba(103, 119, 239, .14);
        }

        .inputx .i {
            width: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: .85;
        }

        .inputx input {
            border: 0 !important;
            outline: none !important;
            background: transparent !important;
            color: var(--text) !important;
            width: 100%;
            font-weight: 600;
        }

        .inputx input::placeholder {
            color: #9aa3b2;
            font-weight: 600;
        }

        /* Toggle button border issue fix */
        .toggle-pass {
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 2px;
            cursor: pointer;
            /* color: rgba(31, 41, 55, .65); */
        }

        .toggle-pass:focus,
        .toggle-pass:active {
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-auth {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 12px 14px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--purple), var(--purple2));
            color: #fff;
            box-shadow: 0 18px 45px rgba(103, 119, 239, .20);
            transition: .18s ease;
        }

        .btn-auth:hover {
            transform: translateY(-1px);
        }

        .bottom-links {
            margin-top: 16px;
            color: #6b7280;
            font-weight: 600;
            text-align: center;
            font-size: 13px;
            line-height: 1.7;
        }

        .linkx {
            color: rgba(103, 119, 239, 1);
            text-decoration: none;
            font-weight: 700;
        }

        .linkx:hover {
            text-decoration: underline;
        }

        .errorbox {
            background: rgba(220, 53, 69, .10);
            border: 1px solid rgba(220, 53, 69, .25);
            color: #b4232a;
            padding: 10px 12px;
            border-radius: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .auth-row {
                grid-template-columns: 1fr;
            }

            .auth-left,
            .auth-right {
                padding: 34px 22px;
            }

            .auth-left::after {
                display: none;
            }

            .left-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-shell">
        <div class="auth-row">

            {{-- LEFT --}}
            <aside class="auth-left">
                <div class="left-inner">
                    <div class="brand">
                        <div class="brand-badge">LA</div>
                        <div>
                            <p class="brand-name mb-0">LMS‑AI</p>
                            <p class="brand-sub">Smart Learning Portal</p>
                        </div>
                    </div>

                    <h3 class="left-title">Start learning with LMS‑AI</h3>
                    <p class="left-sub">
                        Create your account to access courses, AI quizzes, and progress tracking — all in one place.
                    </p>

                    <div class="left-list">
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
                </div>
            </aside>

            {{-- RIGHT --}}
            <main class="auth-right">
                <div class="form-wrap">

                    <h2 class="welcome">Create Account</h2>
                    <p class="welcome-sub">Join the learning platform</p>

                    {{-- error message (optional) --}}
                    @if(session('error'))
                        <div class="errorbox">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        {{-- SUCCESS MESSAGE --}}
                        @if(session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="field-label">Name</label>
                            <div class="inputx @error('name') is-invalid @enderror">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="field-label">Email</label>
                            <div class="inputx @error('email') is-invalid @enderror">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- PHONE --}}
                        <div class="mb-3">
                            <label class="field-label">Mobile</label>
                            <div class="inputx @error('phone') is-invalid @enderror">
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter mobile">
                            </div>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-3">
                            <label class="field-label">Role</label>
                            <select name="role" class="inputx @error('role') is-invalid @enderror" style="width:100%;">
                                <option value="">Select Role</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label class="field-label">Password</label>
                            <div class="inputx @error('password') is-invalid @enderror">
                                <input id="password" type="password" name="password" placeholder="Create password">
                                <button type="button" class="toggle-pass" onclick="togglePassword()">
                                    👁️
                                </button>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="btn-auth">
                            Create Account
                        </button>

                        <div class="bottom-links">
                            <div>
                                Already have an account?
                                <a class="linkx" href="{{ route('login') }}">Login</a>
                            </div>
                            <div>
                                <a class="linkx" href="{{ route('index') }}">← Back to Home</a>
                            </div>
                        </div>
                    </form>


                </div>
            </main>

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