{{-- Admin Dashboard --}}
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #2563eb;">
            <div class="astat-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-people-fill"></i></div>
            <div class="astat-num">{{ $stats['total_users'] }}</div>
            <div class="astat-lbl">Registered Users</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #0891b2;">
            <div class="astat-icon" style="background:#ecfeff;color:#0891b2;"><i class="bi bi-calendar3"></i></div>
            <div class="astat-num">{{ $stats['total_events'] }}</div>
            <div class="astat-lbl">Total Events</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #16a34a;">
            <div class="astat-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-calendar-check"></i></div>
            <div class="astat-num">{{ $stats['active_events'] }}</div>
            <div class="astat-lbl">Active Events</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #d97706;">
            <div class="astat-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-ticket-perforated"></i></div>
            <div class="astat-num">{{ $stats['total_bookings'] }}</div>
            <div class="astat-lbl">Total Bookings</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #16a34a;">
            <div class="astat-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-check-circle"></i></div>
            <div class="astat-num">{{ $stats['confirmed'] }}</div>
            <div class="astat-lbl">Confirmed</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #b45309;">
            <div class="astat-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-hourglass-split"></i></div>
            <div class="astat-num">{{ $stats['pending'] }}</div>
            <div class="astat-lbl">Pending</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="admin-stat" style="border-left:3px solid #1e40af;">
            <div class="astat-icon" style="background:#eff6ff;color:#1e40af;"><i class="bi bi-currency-rupee"></i></div>
            <div class="astat-num" style="font-size:1.4rem;">₹{{ number_format($stats['revenue']) }}</div>
            <div class="astat-lbl">Total Revenue</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Recent Bookings --}}
    <div class="col-lg-8">
        <div class="admin-table">
            <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white border-bottom" style="border-color:#f1f5f9!important;">
                <span class="fw-bold" style="font-size:0.875rem;color:#0f172a;">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Recent Bookings
                </span>
                <a href="{{ route('admin.bookings.index') }}" style="font-size:0.78rem;color:#2563eb;text-decoration:none;font-weight:600;">View all →</a>
            </div>
            @if($recentBookings->isEmpty())
                <div class="text-center py-4 text-muted bg-white" style="font-size:0.875rem;">No bookings yet.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th><th>User</th><th>Event</th><th>Tickets</th><th>Total</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($recentBookings as $b)
                        <tr>
                            <td class="text-muted" style="font-size:0.78rem;">#{{ $b->id }}</td>
                            <td>
                                <div class="fw-semibold" style="font-size:0.83rem;">{{ $b->user->name }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $b->user->email }}</div>
                            </td>
                            <td style="font-size:0.83rem;">{{ Str::limit($b->event->title, 30) }}</td>
                            <td class="fw-semibold">{{ $b->tickets }}</td>
                            <td class="fw-semibold">
                                @if($b->total_price==0) <span style="color:#15803d;">Free</span>
                                @else <span style="color:#1e40af;">₹{{ number_format($b->total_price) }}</span>
                                @endif
                            </td>
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
        <div class="form-card">
            <div class="fw-bold mb-3" style="font-size:0.875rem;color:#0f172a;">Quick Actions</div>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.events.create') }}" class="btn btn-admin-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i>Add New Event
                </a>
                <a href="{{ route('admin.events.index') }}" class="btn text-start" style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;border-radius:8px;font-size:0.875rem;font-weight:600;">
                    <i class="bi bi-calendar3 me-2"></i>Manage Events
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="btn text-start" style="background:#fffbeb;color:#b45309;border:1px solid #fde68a;border-radius:8px;font-size:0.875rem;font-weight:600;">
                    <i class="bi bi-ticket-perforated me-2"></i>Manage Bookings
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn text-start" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:8px;font-size:0.875rem;font-weight:600;">
                    <i class="bi bi-people me-2"></i>Manage Users
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn text-start" style="background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;font-weight:600;">
                    <i class="bi bi-box-arrow-up-right me-2"></i>View Public Site
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
