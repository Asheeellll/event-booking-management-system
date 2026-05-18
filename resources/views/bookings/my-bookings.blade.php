{{-- MY BOOKINGS (bookings/my-bookings.blade.php) --}}
@extends('layouts.app')
@section('title', 'My Bookings')

@section('styles')
<style>
    .page-hero { background:#0f172a; padding:2.5rem 0 3.5rem; border-bottom:1px solid rgba(255,255,255,0.05); }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:1.15rem;
                 transition:box-shadow 0.15s; margin-top:-2rem; position:relative; z-index:10; }
    .stat-num  { font-size:1.6rem; font-weight:800; line-height:1; }
    .stat-lbl  { font-size:0.72rem; font-weight:600; color:#94a3b8; margin-top:3px; text-transform:uppercase; letter-spacing:0.5px; }
    .section-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; }
    .booking-table thead { background:#f8fafc; }
    .booking-table thead th { font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; padding:0.85rem 1rem; border-bottom:2px solid #f1f5f9; border-top:none; }
    .booking-table tbody td { padding:0.85rem 1rem; vertical-align:middle; font-size:0.85rem; border-color:#f8fafc; }
    .booking-table tbody tr:hover { background:#f8fafc; }
    .bs-confirmed { background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:4px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:600; }
    .bs-pending   { background:#fffbeb;color:#b45309;border:1px solid #fde68a;border-radius:4px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:600; }
    .bs-cancelled { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:4px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:600; }
    .btn-cancel { font-size:0.75rem;font-weight:600;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;padding:0.25rem 0.65rem;transition:all 0.15s; }
    .btn-cancel:hover { background:#dc2626;color:#fff;border-color:#dc2626; }
    .mobile-card { background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:1rem;margin-bottom:0.75rem; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white fw-bold mb-1" style="font-size:1.5rem;">My Bookings</h1>
        <p style="color:rgba(255,255,255,0.45);font-size:0.875rem;margin:0;">All your event bookings in one place</p>
    </div>
</div>

<div class="container pb-5">
    {{-- Stats --}}
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="stat-card" style="border-left:3px solid #2563eb;">
                <div class="stat-num" style="color:#1e40af;">{{ $bookings->count() }}</div>
                <div class="stat-lbl">Total</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="border-left:3px solid #16a34a;">
                <div class="stat-num" style="color:#15803d;">{{ $bookings->where('status','confirmed')->count() }}</div>
                <div class="stat-lbl">Confirmed</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="border-left:3px solid #d97706;">
                <div class="stat-num" style="color:#b45309;">{{ $bookings->where('status','pending')->count() }}</div>
                <div class="stat-lbl">Pending</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="border-left:3px solid #dc2626;">
                <div class="stat-num" style="color:#dc2626;">{{ $bookings->where('status','cancelled')->count() }}</div>
                <div class="stat-lbl">Cancelled</div>
            </div>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center py-5 section-card">
            <i class="bi bi-ticket-perforated" style="font-size:3rem;color:#cbd5e1;"></i>
            <h5 class="mt-3" style="color:#334155;">No bookings yet</h5>
            <p class="text-muted" style="font-size:0.875rem;">Start by exploring upcoming events.</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" style="border-radius:7px;">Browse Events</a>
        </div>
    @else
        {{-- Desktop table --}}
        <div class="section-card d-none d-md-block">
            <table class="table table-hover booking-table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>Event</th><th>Date</th><th>Tickets</th><th>Amount</th><th>Status</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                    <tr>
                        <td class="text-muted" style="font-size:0.8rem;">#{{ $b->id }}</td>
                        <td>
                            <a href="{{ route('events.show', $b->event) }}" style="color:#0f172a;font-weight:600;text-decoration:none;">{{ Str::limit($b->event->title, 38) }}</a>
                            <div style="font-size:0.73rem;color:#94a3b8;"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($b->event->venue, 30) }}</div>
                        </td>
                        <td class="text-muted">{{ $b->event->date->format('d M Y') }}</td>
                        <td class="fw-semibold">{{ $b->tickets }}</td>
                        <td class="fw-semibold" style="color:#1e40af;">
                            @if($b->total_price == 0) <span style="color:#15803d;">Free</span>
                            @else ₹{{ number_format($b->total_price) }}
                            @endif
                        </td>
                        <td>
                            @if($b->status==='confirmed') <span class="bs-confirmed">Confirmed</span>
                            @elseif($b->status==='pending') <span class="bs-pending">Pending</span>
                            @else <span class="bs-cancelled">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status==='pending')
                            <form method="POST" action="{{ route('bookings.cancel',$b) }}" onsubmit="return confirm('Cancel this booking?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-cancel">Cancel</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="d-md-none">
            @foreach($bookings as $b)
            <div class="mobile-card">
                <div class="d-flex justify-content-between mb-1">
                    <span class="fw-semibold" style="color:#0f172a;font-size:0.88rem;">{{ Str::limit($b->event->title, 32) }}</span>
                    @if($b->status==='confirmed') <span class="bs-confirmed">Confirmed</span>
                    @elseif($b->status==='pending') <span class="bs-pending">Pending</span>
                    @else <span class="bs-cancelled">Cancelled</span>
                    @endif
                </div>
                <div style="font-size:0.78rem;color:#64748b;">
                    {{ $b->event->date->format('d M Y') }} &middot; {{ $b->tickets }} ticket(s) &middot;
                    <strong style="color:#1e40af;">@if($b->total_price==0) Free @else ₹{{ number_format($b->total_price) }} @endif</strong>
                </div>
                @if($b->status==='pending')
                <form method="POST" action="{{ route('bookings.cancel',$b) }}" onsubmit="return confirm('Cancel?');" class="mt-2">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-cancel w-100">Cancel Booking</button>
                </form>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm" style="border-radius:7px;">Book More Events</a>
        </div>
    @endif
</div>
@endsection
