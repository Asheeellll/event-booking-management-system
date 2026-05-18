{{--
    LOGIN PAGE (auth/login.blade.php)
    -----------------------------------
    Professional two-column layout: illustration left, form right.
    Color palette: deep blue + white. No flashy gradients.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — EventBook India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f8fafc; font-family:'Segoe UI',system-ui,sans-serif; }

        .auth-wrapper { min-height: 100vh; display: flex; }

        /* Left panel — brand/illustration */
        .auth-left {
            background: #0f172a;
            display: flex; flex-direction: column;
            justify-content: center; align-items: flex-start;
            padding: 3rem;
        }
        .auth-left .brand { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 2.5rem; }
        .auth-left .brand span { color: #60a5fa; }
        .auth-left h2 { font-size: 1.8rem; font-weight: 700; color: #fff; line-height: 1.3; }
        .auth-left p  { color: rgba(255,255,255,0.55); font-size: 0.9rem; margin-top: 0.75rem; max-width: 340px; }

        .feature-list { list-style: none; padding: 0; margin-top: 2rem; }
        .feature-list li {
            display: flex; align-items: center; gap: 0.75rem;
            color: rgba(255,255,255,0.65); font-size: 0.875rem;
            margin-bottom: 0.85rem;
        }
        .feature-list li .fi {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(96,165,250,0.15);
            display: flex; align-items: center; justify-content: center;
            color: #60a5fa; font-size: 0.85rem; flex-shrink: 0;
        }

        /* Right panel — form */
        .auth-right {
            background: #fff;
            display: flex; flex-direction: column;
            justify-content: center; padding: 3rem 2.5rem;
        }

        .auth-form-container { max-width: 380px; width: 100%; margin: auto; }

        .form-label { font-weight: 600; font-size: 0.82rem; color: #334155; margin-bottom: 0.3rem; }
        .form-control {
            font-size: 0.9rem; padding: 0.6rem 0.85rem;
            border-color: #e2e8f0; border-radius: 8px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .btn-signin {
            background: #1e40af; color: #fff;
            border: none; border-radius: 8px;
            font-weight: 600; font-size: 0.9rem;
            padding: 0.65rem; width: 100%;
            transition: background 0.15s;
        }
        .btn-signin:hover { background: #1e3a8a; color: #fff; }
        .divider { position: relative; text-align: center; margin: 1.2rem 0; }
        .divider::before {
            content: ''; position: absolute; top: 50%; left: 0; right: 0;
            height: 1px; background: #e2e8f0;
        }
        .divider span {
            background: #fff; position: relative;
            padding: 0 0.75rem; font-size: 0.78rem; color: #94a3b8;
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    {{-- Left Panel --}}
    <div class="auth-left d-none d-lg-flex col-lg-5">
        <div class="brand">
            <i class="bi bi-calendar-event me-2" style="color:#60a5fa;"></i>Event<span>Book</span>
        </div>
        <h2>Discover events<br>happening near you</h2>
        <p>Sign in to manage your bookings, explore upcoming events, and get personalised recommendations.</p>
        <ul class="feature-list">
            <li><div class="fi"><i class="bi bi-search"></i></div> Browse 100+ curated events</li>
            <li><div class="fi"><i class="bi bi-ticket-perforated"></i></div> Book tickets in seconds</li>
            <li><div class="fi"><i class="bi bi-shield-check"></i></div> Secure, instant confirmation</li>
        </ul>
    </div>

    {{-- Right Panel --}}
    <div class="auth-right col-12 col-lg-7">
        <div class="auth-form-container">
            {{-- Mobile brand --}}
            <div class="d-lg-none mb-4" style="font-size:1.3rem;font-weight:700;color:#0f172a;">
                <i class="bi bi-calendar-event me-2" style="color:#2563eb;"></i>EventBook
            </div>

            <h4 class="fw-bold mb-1" style="color:#0f172a;">Welcome back</h4>
            <p class="text-muted mb-4" style="font-size:0.875rem;">Sign in to your account to continue</p>

            {{-- Session status (e.g. password reset success) --}}
            @if(session('status'))
                <div class="alert alert-success py-2 mb-3" style="font-size:0.85rem;border-radius:8px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" autocomplete="email" autofocus
                           placeholder="you@example.com">
                    @error('email')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password">
                    @error('password')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="font-size:0.83rem;color:#64748b;">
                            Remember me
                        </label>
                    </div>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:0.83rem;color:#2563eb;text-decoration:none;">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-signin">
                    Sign In
                </button>
            </form>

            <div class="divider"><span>or</span></div>

            <p class="text-center mb-0" style="font-size:0.875rem;color:#64748b;">
                Don't have an account?
                <a href="{{ route('register') }}" style="color:#2563eb;font-weight:600;text-decoration:none;">
                    Create one free
                </a>
            </p>

            {{-- Demo credentials box --}}
            <div class="mt-4 p-3" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;font-size:0.78rem;color:#64748b;">
                <div class="fw-semibold mb-1" style="color:#334155;">Demo Credentials</div>
                <div><span class="fw-semibold">Admin:</span> admin@eventbook.in / password</div>
                <div><span class="fw-semibold">User:</span> arjun@example.com / password</div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
