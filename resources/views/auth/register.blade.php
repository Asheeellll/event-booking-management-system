{{--
    REGISTER PAGE (auth/register.blade.php)
    -----------------------------------------
    Matches the login two-column layout for design consistency.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — EventBook India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f8fafc; font-family:'Segoe UI',system-ui,sans-serif; }
        .auth-wrapper { min-height:100vh; display:flex; }
        .auth-left {
            background: #0f172a;
            display: flex; flex-direction: column;
            justify-content: center; padding: 3rem;
        }
        .auth-left .brand { font-size:1.4rem; font-weight:700; color:#fff; margin-bottom:2rem; }
        .auth-left .brand span { color:#60a5fa; }
        .auth-left h2 { font-size:1.7rem; font-weight:700; color:#fff; line-height:1.3; }
        .auth-left p  { color:rgba(255,255,255,0.55); font-size:0.875rem; margin-top:0.6rem; max-width:340px; }
        .step-list { list-style:none; padding:0; margin-top:2rem; }
        .step-list li {
            display:flex; align-items:flex-start; gap:0.75rem;
            color:rgba(255,255,255,0.6); font-size:0.85rem; margin-bottom:1rem;
        }
        .step-num {
            width:24px; height:24px; border-radius:50%;
            background:#2563eb; color:#fff;
            display:flex; align-items:center; justify-content:center;
            font-size:0.72rem; font-weight:700; flex-shrink:0; margin-top:1px;
        }
        .auth-right {
            background:#fff; display:flex; flex-direction:column;
            justify-content:center; padding:2.5rem 2rem; overflow-y:auto;
        }
        .auth-form-container { max-width:400px; width:100%; margin:auto; }
        .form-label { font-weight:600; font-size:0.82rem; color:#334155; margin-bottom:0.3rem; }
        .form-control {
            font-size:0.9rem; padding:0.6rem 0.85rem;
            border-color:#e2e8f0; border-radius:8px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus {
            border-color:#2563eb;
            box-shadow:0 0 0 3px rgba(37,99,235,0.1);
        }
        .btn-register {
            background:#1e40af; color:#fff; border:none;
            border-radius:8px; font-weight:600; font-size:0.9rem;
            padding:0.65rem; width:100%; transition:background 0.15s;
        }
        .btn-register:hover { background:#1e3a8a; color:#fff; }
    </style>
</head>
<body>
<div class="auth-wrapper">

    {{-- Left Panel --}}
    <div class="auth-left d-none d-lg-flex col-lg-5">
        <div class="brand">
            <i class="bi bi-calendar-event me-2" style="color:#60a5fa;"></i>Event<span>Book</span>
        </div>
        <h2>Your events,<br>your way</h2>
        <p>Join thousands of event-goers across India. Create your free account and start exploring.</p>
        <ul class="step-list">
            <li>
                <div class="step-num">1</div>
                <div><strong style="color:rgba(255,255,255,0.85);">Create Account</strong><br>Free, takes 30 seconds</div>
            </li>
            <li>
                <div class="step-num">2</div>
                <div><strong style="color:rgba(255,255,255,0.85);">Browse Events</strong><br>Tech, music, sports and more</div>
            </li>
            <li>
                <div class="step-num">3</div>
                <div><strong style="color:rgba(255,255,255,0.85);">Book Instantly</strong><br>Confirmed tickets, zero hassle</div>
            </li>
        </ul>
    </div>

    {{-- Right Panel --}}
    <div class="auth-right col-12 col-lg-7">
        <div class="auth-form-container">
            <div class="d-lg-none mb-4" style="font-size:1.3rem;font-weight:700;color:#0f172a;">
                <i class="bi bi-calendar-event me-2" style="color:#2563eb;"></i>EventBook
            </div>

            <h4 class="fw-bold mb-1" style="color:#0f172a;">Create your account</h4>
            <p class="text-muted mb-4" style="font-size:0.875rem;">All fields marked <span class="text-danger">*</span> are required</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Full Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input id="name" type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. Arjun Sharma"
                           autocomplete="name" autofocus>
                    @error('name')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="you@example.com">
                    @error('email')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input id="phone" type="text" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           placeholder="+91 98100 00000">
                    @error('phone')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 characters">
                    @error('password')
                        <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        Confirm Password <span class="text-danger">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Repeat your password">
                </div>

                <button type="submit" class="btn-register">
                    Create Account
                </button>
            </form>

            <p class="text-center mt-4 mb-0" style="font-size:0.875rem;color:#64748b;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:#2563eb;font-weight:600;text-decoration:none;">
                    Sign in
                </a>
            </p>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
