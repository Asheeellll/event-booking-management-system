{{-- USER DASHBOARD (dashboard.blade.php) --}}
@extends('layouts.app')
@section('title', 'My Dashboard')

@section('styles')
<style>
    .dash-header { background:#0f172a; padding:2.5rem 0 4.5rem; border-bottom:1px solid rgba(255,255,255,0.05); }
    .dash-avatar { width:48px;height:48px;border-radius:12px;background:#2563eb;color:#fff;
                   display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700; }
    .stat-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.4rem;
                 transition:box-shadow 0.15s;margin-top:-2.5rem;position:relative;z-index:10; }
    .stat-card:hover { box-shadow:0 4px 15px rgba(15,23,42,0.08); }
    .stat-icon { width:44px;height:44px;border-radius:10px;display:flex;align-items:center;
                 justify-content:center;font-size:1.1rem;margin-bottom:0.75rem; }
    .stat-num  { font-size:1.8rem;font-weight:800;line-height:1;color:#0f172a; }
    .stat-lbl  { font-size:0.72rem;font-weight:600;color:#94a3b8;margin-top:3px;text-transform:uppercase;letter-spacing:0.5px; }
    .section-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden; }
    .section-header { padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;font-size:0.875rem;font-weight:700;color:#0f172a; }
    .recent-table thead th { font-size:0.73rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;padding:0.7rem 1rem;background:#f8fafc;border-bottom:1px solid #f1f5f9;border-top:none; }
    .recent-table tbody td { padding:0.85rem 1rem;font-size:0.84rem;vertical-align:middle;border-color:#f8fafc; }
    .recent-table tbody tr:hover { background:#fafafa; }
    .bs-confirmed { background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
    .bs-pending   { background:#fffbeb;color:#b45309;border:1px solid #fde68a;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
    .bs-cancelled { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.7rem;font-weight:600; }
    .action-card { display:block;background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                   padding:1.15rem;text-decoration:none;transition:all 0.15s; }
    .action-card:hover { box-shadow:0 4px 12px rgba(15,23,42,0.08);border-color:#bfdbfe;transform:translateY(-1px); }
    .action-icon { width:40px;height:40px;border-radius:9px;background:#eff6ff;color:#2563eb;
                   display:flex;align-items:center;justify-content:center;font-size:1rem;margin-bottom:0.6rem; }
</style>
@endsection

@section('content')
<div class="dash-header">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="dash-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;">Welcome back</div>
                <div class="fw-bold text-white" style="font-size:1.2rem;">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-ticket-perforated"></i></div>
                <div class="stat-num" style="color:#1e40af;">{{ $stats['total'] }}</div>
                <div class="stat-lbl">Total Bookings</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-check-circle"></i></div>
                <div class="stat-num" style="color:#15803d;">{{ $stats['confirmed'] }}</div>
                <div class="stat-lbl">Confirmed</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-num" style="color:#b45309;">{{ $stats['pending'] }}</div>
                <div class="stat-lbl">Pending</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef2f2;color:#dc2626;"><i class="bi bi-x-circle"></i></div>
                <div class="stat-num" style="color:#dc2626;">{{ $stats['cancelled'] }}</div>
                <div class="stat-lbl">Cancelled</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Recent Bookings --}}
        <div class="col-lg-8">
            <div class="section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2 text-primary"></i>Recent Bookings</span>
                    <a href="{{ route('bookings.my') }}" style="font-size:0.78rem;color:#2563eb;text-decoration:none;font-weight:600;">View all →</a>
                </div>
                @if($bookings->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x" style="font-size:2.5rem;opacity:0.3;"></i>
                        <p class="mt-2 mb-3" style="font-size:0.875rem;">No bookings yet.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" style="border-radius:7px;">Browse Events</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table recent-table mb-0">
                            <thead><tr><th>Event</th><th>Date</th><th>Tickets</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach($bookings->take(5) as $b)
                                <tr>
                                    <td>
                                        <a href="{{ route('events.show', $b->event) }}" style="color:#0f172a;font-weight:600;text-decoration:none;font-size:0.83rem;">
                                            {{ Str::limit($b->event->title, 38) }}
                                        </a>
                                    </td>
                                    <td class="text-muted">{{ $b->event->date->format('d M Y') }}</td>
                                    <td class="fw-semibold">{{ $b->tickets }}</td>
                                    <td>
                                        @if($b->status==='confirmed') <span class="bs-confirmed">Confirmed</span>
                                        @elseif($b->status==='pending') <span class="bs-pending">Pending</span>
                                        @else <span class="bs-cancelled">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:0.75rem;">Quick Actions</div>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('events.index') }}" class="action-card">
                    <div class="action-icon"><i class="bi bi-search"></i></div>
                    <div class="fw-semibold" style="color:#0f172a;font-size:0.875rem;">Browse Events</div>
                    <div class="text-muted" style="font-size:0.75rem;">Find your next event</div>
                </a>
                <a href="{{ route('bookings.my') }}" class="action-card">
                    <div class="action-icon"><i class="bi bi-ticket-perforated"></i></div>
                    <div class="fw-semibold" style="color:#0f172a;font-size:0.875rem;">All My Bookings</div>
                    <div class="text-muted" style="font-size:0.75rem;">Full booking history</div>
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="action-card" style="border-left:3px solid #1e40af;">
                    <div class="action-icon"><i class="bi bi-speedometer2"></i></div>
                    <div class="fw-semibold" style="color:#0f172a;font-size:0.875rem;">Admin Panel</div>
                    <div class="text-muted" style="font-size:0.75rem;">Manage events &amp; users</div>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
