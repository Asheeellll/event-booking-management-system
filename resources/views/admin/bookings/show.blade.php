{{-- Admin: Booking Detail --}}
@extends('layouts.admin')
@section('title', 'Booking #' . $booking->id)
@section('page-title', 'Booking Detail')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.bookings.index') }}" style="color:#64748b;text-decoration:none;font-size:0.83rem;">
        <i class="bi bi-arrow-left me-1"></i>Back to Bookings
    </a>
</div>
<div class="row g-4">
    <div class="col-md-8">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <h5 class="fw-bold mb-0" style="font-size:0.95rem;color:#0f172a;">
                    <i class="bi bi-ticket-perforated me-2 text-primary"></i>Booking #{{ $booking->id }}
                </h5>
                @if($booking->status==='confirmed') <span class="bs-confirmed">Confirmed</span>
                @elseif($booking->status==='pending') <span class="bs-pending">Pending</span>
                @else <span class="bs-cancelled">Cancelled</span>
                @endif
            </div>
            <table class="table table-borderless" style="font-size:0.875rem;">
                <tr><td class="text-muted fw-semibold" style="width:35%;font-size:0.8rem;">User</td><td>{{ $booking->user->name }} &lt;{{ $booking->user->email }}&gt;</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Event</td><td class="fw-semibold">{{ $booking->event->title }}</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Date &amp; Time</td><td>{{ $booking->event->date->format('D, d F Y') }} at {{ \Carbon\Carbon::parse($booking->event->time)->format('g:i A') }}</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Venue</td><td>{{ $booking->event->venue }}</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Tickets</td><td class="fw-semibold">{{ $booking->tickets }}</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Total Amount</td>
                    <td class="fw-bold" style="color:#1e40af;">
                        @if($booking->total_price==0) Free @else ₹{{ number_format($booking->total_price) }} @endif
                    </td>
                </tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Notes</td><td>{{ $booking->notes ?? '—' }}</td></tr>
                <tr><td class="text-muted fw-semibold" style="font-size:0.8rem;">Booked On</td><td>{{ $booking->created_at->format('D, d M Y, g:i A') }}</td></tr>
            </table>
            <hr style="border-color:#f1f5f9;">
            <h6 class="fw-bold mb-3" style="font-size:0.85rem;">Update Status</h6>
            <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="d-flex gap-2">
                @csrf @method('PATCH')
                <select name="status" class="form-select" style="max-width:200px;">
                    <option value="pending"   {{ $booking->status==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status==='confirmed' ? 'selected':'' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status==='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-admin-primary">Update</button>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:0.85rem;">User Details</h6>
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-person me-2 text-primary"></i><strong class="text-dark">{{ $booking->user->name }}</strong></div>
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-envelope me-2 text-primary"></i>{{ $booking->user->email }}</div>
            @if($booking->user->phone)
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-telephone me-2 text-primary"></i>{{ $booking->user->phone }}</div>
            @endif
            <hr style="border-color:#f1f5f9;">
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-calendar3 me-2 text-primary"></i>Event on {{ $booking->event->date->format('d M Y') }}</div>
            <div class="text-muted" style="font-size:0.83rem;"><i class="bi bi-grid me-2 text-primary"></i>{{ $booking->event->category->name }}</div>
        </div>
    </div>
</div>
@endsection
