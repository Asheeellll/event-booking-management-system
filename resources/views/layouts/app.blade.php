{{--
    MAIN PUBLIC LAYOUT (layouts/app.blade.php)
    -------------------------------------------
    Base layout for all public pages.
    Design: Professional deep-blue navbar, clean white body, minimal footer.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventManage Pro') — EventManage Pro</title>
    <meta name="description" content="@yield('description', 'Premier event management company in India. Weddings, corporate, concerts & more.')">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── Design Tokens ──────────────────────────────────────────── */
        :root {
            --primary:       #1e40af;
            --primary-hover: #1e3a8a;
            --primary-light: #eff6ff;
            --accent:        #2563eb;
            --bg-body:       #f8fafc;
            --bg-card:       #ffffff;
            --text-dark:     #0f172a;
            --text-body:     #334155;
            --text-muted:    #64748b;
            --border:        #e2e8f0;
            --shadow-sm:     0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:     0 4px 6px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            font-size: 0.9375rem;
        }

        /* ── Navbar ─────────────────────────────────────────────────── */
        .navbar-main {
            background-color: #0f172a;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding: 0.75rem 0;
        }
        .navbar-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff !important;
            letter-spacing: -0.3px;
        }
        .navbar-brand-text span { color: #60a5fa; }

        .navbar-main .nav-link {
            color: rgba(255,255,255,0.7) !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.4rem 0.9rem !important;
            border-radius: 6px;
            transition: color 0.15s, background 0.15s;
        }
        .navbar-main .nav-link:hover {
            color: #fff !important;
            background: rgba(37,99,235,0.15);
        }
        .navbar-main .nav-link.active {
            color: #2563EB !important;
            background: transparent;
        }
        .navbar-toggler {
            border-color: rgba(255,255,255,0.2);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.7%29' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Auth buttons in navbar */
        .btn-nav-login {
            font-size: 0.85rem; font-weight: 600;
            color: #2563EB !important;
            border: 1px solid #2563EB;
            border-radius: 6px; padding: 0.35rem 1rem;
            transition: all 0.15s; background: #FFFFFF;
        }
        .btn-nav-login:hover {
            background: #F8FAFC;
            color: #1D4ED8 !important;
            border-color: #1D4ED8;
        }
        .btn-nav-signup {
            font-size: 0.85rem; font-weight: 600;
            background: #2563eb; color: #fff !important;
            border: none; border-radius: 6px; padding: 0.35rem 1.1rem;
            transition: background 0.15s;
        }
        .btn-nav-signup:hover { background: #1d4ed8; color: #fff !important; }

        /* Dropdown */
        .navbar-main .dropdown-menu {
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            min-width: 190px;
            margin-top: 0.5rem;
        }
        .navbar-main .dropdown-item {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            padding: 0.55rem 1rem;
            transition: all 0.15s;
        }
        .navbar-main .dropdown-item:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }
        .navbar-main .dropdown-divider { border-color: rgba(255,255,255,0.08); }
        .navbar-main .dropdown-item.text-danger { color: #f87171 !important; }
        .navbar-main .dropdown-item.text-danger:hover { background: rgba(239,68,68,0.1); }

        /* ── Flash Alerts ────────────────────────────────────────────── */
        .alert-app-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #166534; border-radius: 8px; font-size: 0.875rem;
        }
        .alert-app-error {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #991b1b; border-radius: 8px; font-size: 0.875rem;
        }

        /* ── Global Button ───────────────────────────────────────────── */
        .btn-primary-app {
            background: #2563EB; color: #fff;
            border: none; border-radius: 7px;
            font-weight: 600; font-size: 0.875rem;
            padding: 0.5rem 1.25rem;
            transition: background 0.15s, box-shadow 0.15s;
        }
        .btn-primary-app:hover {
            background: #1D4ED8; color: #fff;
            box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        }

        /* ── Footer ─────────────────────────────────────────────────── */
        .footer-main {
            background: #0f172a;
            border-top: 1px solid rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.5);
            padding: 2.5rem 0 1.5rem;
            margin-top: 4rem;
            font-size: 0.875rem;
        }
        .footer-main .footer-brand {
            font-size: 1.1rem; font-weight: 700; color: #fff;
        }
        .footer-main .footer-brand span { color: #60a5fa; }
        .footer-main a {
            color: rgba(255,255,255,0.45);
            text-decoration: none; transition: color 0.15s;
        }
        .footer-main a:hover { color: #93c5fd; }
        .footer-main h6 { color: rgba(255,255,255,0.7); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

        @yield('styles')
    </style>
</head>
<body>

{{-- ── NAVBAR ──────────────────────────────────────────────────────── --}}
<nav class="navbar navbar-expand-lg navbar-main sticky-top">
    <div class="container">
        <a class="navbar-brand navbar-brand-text" href="{{ route('home') }}">
            <i class="bi bi-stars me-2" style="color:#60a5fa;"></i>Event<span>Manage</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
                        Events
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.my') }}">
                        My Enquiries
                    </a>
                </li>
                @endauth
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-nav-login">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-nav-signup">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <span style="width:30px;height:30px;border-radius:50%;background:#1e40af;
                                         display:inline-flex;align-items:center;justify-content:center;
                                         font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span style="color:rgba(255,255,255,0.85);font-size:0.875rem;">
                                {{ explode(' ', auth()->user()->name)[0] }}
                            </span>
                            @if(auth()->user()->isAdmin())
                                <span class="badge" style="background:#2563eb;font-size:0.65rem;padding:0.2rem 0.5rem;">ADMIN</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2" style="color:#60a5fa;"></i>Admin Panel
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-grid me-2 opacity-75"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('bookings.my') }}">
                                    <i class="bi bi-chat-dots me-2 opacity-75"></i>My Enquiries
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- ── FLASH MESSAGES ──────────────────────────────────────────────── --}}
<div class="container" style="margin-top:1rem;">
    @if(session('success'))
        <div class="alert alert-app-success alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-app-error alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-circle-fill text-danger"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- ── PAGE CONTENT ────────────────────────────────────────────────── --}}
@yield('content')

{{-- ── FOOTER ──────────────────────────────────────────────────────── --}}
<footer class="footer-main">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="footer-brand mb-2">
                    <i class="bi bi-stars me-2" style="color:#60a5fa;"></i>Event<span>Manage</span>
                </div>
                <p class="mb-0" style="line-height:1.7;">
                    India's premier event management company. Weddings, corporate events, concerts and private celebrations.
                </p>
            </div>
            <div class="col-md-4">
                <h6 class="mb-3">Navigation</h6>
                <ul class="list-unstyled mb-0" style="line-height:2;">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('events.index') }}">Browse Events</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}">My Dashboard</a></li>
                        <li><a href="{{ route('bookings.my') }}">My Enquiries</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="mb-3">Contact</h6>
                <ul class="list-unstyled mb-0" style="line-height:2.2;">
                    <li><i class="bi bi-envelope me-2" style="color:#60a5fa;"></i>hello@eventbook.in</li>
                    <li><i class="bi bi-telephone me-2" style="color:#60a5fa;"></i>+91 80 4600 0000</li>
                    <li><i class="bi bi-geo-alt me-2" style="color:#60a5fa;"></i>Bengaluru, Karnataka</li>
                </ul>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.07);margin:2rem 0 1rem;">
        <p class="text-center mb-0" style="font-size:0.8rem;">
            &copy; {{ date('Y') }} EventManage Pro. Built with Laravel 10 &amp; Bootstrap 5.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
