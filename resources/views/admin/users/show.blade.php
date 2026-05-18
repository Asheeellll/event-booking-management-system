{{-- Admin: User Profile --}}
@extends('layouts.admin')
@section('title', 'User: ' . $user->name)
@section('page-title', 'User Profile')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" style="color:#666;text-decoration:none;font-size:0.88rem;">
        <i class="bi bi-arrow-left me-1"></i>Back to Users
    </a>
</div>

<div class="row g-4">
    {{-- User Profile Card --}}
    <div class="col-md-4">
        <div class="form-card text-center">
            <div style="width:80px;height:80px;border-radius:50%;
                        background:rgba(233,69,96,0.1);border:3px solid rgba(233,69,96,0.3);
                        display:flex;align-items:center;justify-content:center;
                        font-size:2rem;color:#e94560;margin:0 auto 1rem;">
                <i class="bi bi-person-fill"></i>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <div class="text-muted mb-3" style="font-size:0.85rem;">{{ $user->email }}</div>

            <div class="text-start">
                <div class="mb-2" style="font-size:0.85rem;">
                    <i class="bi bi-telephone me-2 text-danger"></i>
                    {{ $user->phone ?? 'Not provided' }}
                </div>
                <div class="mb-2" style="font-size:0.85rem;">
                    <i class="bi bi-calendar3 me-2 text-danger"></i>
                    Joined {{ $user->created_at->format('d M Y') }}
                </div>
                <div style="font-size:0.85rem;">
                    <i class="bi bi-ticket-perforated me-2 text-danger"></i>
                    {{ $bookings->count() }} total booking(s)
                </div>
            </div>
        </div>
    </div>

    {{-- User Bookings --}}
    <div class="col-md-8">
        <div class="form-card">
            <h6 class="fw-bold mb-3">Booking History</h6>
            @if($bookings->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-calendar-x" style="font-size:2rem;"></i>
                    <p class="mt-2">No bookings yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:0.85rem;">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th style="font-size:0.78rem;color:#666;padding:0.7rem;">Event</th>
                                <th style="font-size:0.78rem;color:#666;padding:0.7rem;">Date</th>
                                <th style="font-size:0.78rem;color:#666;padding:0.7rem;">Tickets</th>
                                <th style="font-size:0.78rem;color:#666;padding:0.7rem;">Total</th>
                                <th style="font-size:0.78rem;color:#666;padding:0.7rem;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td style="padding:0.75rem;">
                                    {{ Str::limit($booking->event->title, 35) }}
                                </td>
                                <td style="padding:0.75rem;" class="text-muted">
                                    {{ $booking->event->date->format('d M Y') }}
                                </td>
                                <td style="padding:0.75rem;" class="fw-bold">
                                    {{ $booking->tickets }}
                                </td>
                                <td style="padding:0.75rem;font-weight:700;">
                                    @if($booking->total_price == 0)
                                        <span style="color:#28a745;">Free</span>
                                    @else
                                        <span style="color:#e94560;">PKR {{ number_format($booking->total_price) }}</span>
                                    @endif
                                </td>
                                <td style="padding:0.75rem;">
                                    @if($booking->status === 'confirmed')
                                        <span class="bs-confirmed">Confirmed</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="bs-pending">Pending</span>
                                    @else
                                        <span class="bs-cancelled">Cancelled</span>
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
</div>
@endsection
