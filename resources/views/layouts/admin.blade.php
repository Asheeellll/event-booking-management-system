{{-- ADMIN LAYOUT (layouts/admin.blade.php) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | EventBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 240px; --sidebar-bg: #0f172a; --topbar-h: 56px; }
        body { font-family:'Segoe UI',system-ui,sans-serif; background:#f1f5f9; font-size:0.9rem; }

        /* Sidebar */
        .sidebar {
            position:fixed; top:0; left:0; width:var(--sidebar-w); height:100vh;
            background:var(--sidebar-bg); z-index:1000; display:flex;
            flex-direction:column; overflow-y:auto;
            border-right:1px solid rgba(255,255,255,0.04);
        }
        .sidebar-brand { padding:1.25rem 1.25rem 1rem; border-bottom:1px solid rgba(255,255,255,0.05); }
        .sidebar-brand .brand-text { font-size:1.1rem;font-weight:700;color:#fff; }
        .sidebar-brand .brand-text span { color:#60a5fa; }
        .sidebar-brand .sub { font-size:0.68rem;color:rgba(255,255,255,0.3);letter-spacing:1px;text-transform:uppercase;margin-top:1px; }
        .nav-section { font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;
                       color:rgba(255,255,255,0.25);padding:1rem 1.25rem 0.35rem; }
        .sidebar-link { display:flex;align-items:center;gap:0.65rem;padding:0.6rem 1.25rem;
                        color:rgba(255,255,255,0.55);text-decoration:none;font-size:0.82rem;
                        font-weight:500;transition:all 0.15s;border-left:2px solid transparent; }
        .sidebar-link:hover { color:#fff;background:rgba(255,255,255,0.05);border-left-color:rgba(96,165,250,0.4); }
        .sidebar-link.active { color:#fff;background:rgba(37,99,235,0.15);border-left-color:#3b82f6; }
        .sidebar-link i { font-size:0.95rem;width:18px;text-align:center; }
        .sidebar-footer { padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,0.05);margin-top:auto; }
        .sidebar-footer .user-name { font-size:0.78rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem; }
        .btn-logout { width:100%;font-size:0.78rem;font-weight:600;background:rgba(239,68,68,0.1);
                      color:#f87171;border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:0.4rem; }
        .btn-logout:hover { background:rgba(239,68,68,0.2);color:#fca5a5; }

        /* Main */
        .main-wrap { margin-left:var(--sidebar-w); display:flex;flex-direction:column;min-height:100vh; }

        /* Topbar */
        .topbar { background:#fff;border-bottom:1px solid #e2e8f0;height:var(--topbar-h);
                  padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;
                  position:sticky;top:0;z-index:100; }
        .topbar .page-title { font-size:1rem;font-weight:700;color:#0f172a;margin:0; }
        .admin-badge { background:#eff6ff;color:#1e40af;font-size:0.7rem;font-weight:700;
                       border:1px solid #bfdbfe;border-radius:4px;padding:0.15rem 0.5rem; }

        /* Flash */
        .flash-zone { padding:1rem 1.5rem 0; }
        .alert-admin-success { background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:8px;font-size:0.85rem; }
        .alert-admin-error   { background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:8px;font-size:0.85rem; }

        /* Content */
        .page-content { padding:1.5rem;flex:1; }

        /* Tables */
        .admin-table { background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden; }
        .admin-table thead { background:#f8fafc; }
        .admin-table thead th { font-size:0.73rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;padding:0.85rem 1rem;border-bottom:2px solid #f1f5f9;border-top:none; }
        .admin-table tbody td { padding:0.85rem 1rem;font-size:0.84rem;vertical-align:middle;border-color:#f8fafc; }
        .admin-table tbody tr:hover { background:#fafbff; }

        /* Status badges */
        .bs-confirmed { background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
        .bs-pending   { background:#fffbeb;color:#b45309;border:1px solid #fde68a;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
        .bs-cancelled { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
        .bs-active    { background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }

        /* Stat cards */
        .admin-stat { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.25rem;transition:box-shadow 0.15s; }
        .admin-stat:hover { box-shadow:0 4px 12px rgba(15,23,42,0.07); }
        .astat-icon { width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:0.75rem; }
        .astat-num  { font-size:1.75rem;font-weight:800;color:#0f172a;line-height:1; }
        .astat-lbl  { font-size:0.72rem;font-weight:600;color:#94a3b8;margin-top:3px;text-transform:uppercase;letter-spacing:0.5px; }

        /* Form cards */
        .form-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.75rem; }
        .form-label { font-size:0.8rem;font-weight:600;color:#475569;margin-bottom:0.3rem; }
        .form-control,.form-select { font-size:0.875rem;border-color:#e2e8f0;border-radius:8px;padding:0.55rem 0.85rem; }
        .form-control:focus,.form-select:focus { border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
        .btn-admin-primary { background:#1e40af;color:#fff;border:none;border-radius:8px;font-weight:600;font-size:0.875rem;padding:0.55rem 1.25rem;transition:background 0.15s; }
        .btn-admin-primary:hover { background:#1e3a8a;color:#fff; }

        /* Action buttons */
        .btn-act-edit   { background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;border-radius:6px;padding:0.28rem 0.6rem;font-size:0.75rem;transition:all 0.15s; }
        .btn-act-edit:hover   { background:#1e40af;color:#fff;border-color:#1e40af; }
        .btn-act-delete { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;padding:0.28rem 0.6rem;font-size:0.75rem;transition:all 0.15s; }
        .btn-act-delete:hover { background:#dc2626;color:#fff;border-color:#dc2626; }
        .btn-act-view   { background:#f8fafc;color:#475569;border:1px solid #e2e8f0;border-radius:6px;padding:0.28rem 0.6rem;font-size:0.75rem;transition:all 0.15s; }
        .btn-act-view:hover   { background:#0f172a;color:#fff;border-color:#0f172a; }

        @media (max-width:768px) {
            .sidebar { transform:translateX(-100%);transition:transform 0.25s; }
            .sidebar.show { transform:translateX(0); }
            .main-wrap { margin-left:0; }
        }

        @yield('styles')
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-text"><i class="bi bi-calendar-event me-2" style="color:#60a5fa;"></i>Event<span>Book</span></div>
        <div class="sub">Admin Panel</div>
    </div>
    <nav style="padding:0.5rem 0;flex:1;">
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-section">Manage</div>
        <a href="{{ route('admin.events.index') }}" class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Events
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="bi bi-ticket-perforated"></i> Bookings
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <div class="nav-section">Site</div>
        <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
            <i class="bi bi-globe"></i> Public Site
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-name"><i class="bi bi-person-fill me-1"></i>{{ auth()->user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right me-1"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm d-md-none me-1 p-1" onclick="document.getElementById('sidebar').classList.toggle('show')" style="border:none;background:none;">
                <i class="bi bi-list" style="font-size:1.3rem;"></i>
            </button>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span style="font-size:0.82rem;color:#64748b;">{{ auth()->user()->name }}</span>
            <span class="admin-badge">ADMIN</span>
        </div>
    </div>

    <div class="flash-zone">
        @if(session('success'))
            <div class="alert alert-admin-success alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i> {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-admin-error alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill text-danger flex-shrink-0"></i> {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
