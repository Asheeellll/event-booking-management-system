{{-- Admin: Enquiry Detail (admin/bookings/show.blade.php) --}}
@extends('layouts.admin')
@section('title', 'Enquiry #' . $booking->id)
@section('page-title', 'Enquiry Detail')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.bookings.index') }}" style="color:#64748b;text-decoration:none;font-size:0.83rem;">
        <i class="bi bi-arrow-left me-1"></i>Back to Enquiries
    </a>
</div>

<div class="row g-4">
    {{-- Main Details --}}
    <div class="col-md-8">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <h5 class="fw-bold mb-0" style="font-size:0.95rem;color:#0f172a;">
                    <i class="bi bi-chat-dots me-2 text-primary"></i>Enquiry #{{ $booking->id }}
                </h5>
                {{-- DB: pending/confirmed/cancelled → UI: Pending/Approved/Rejected --}}
                @if($booking->status==='confirmed') <span class="bs-confirmed">✓ Approved</span>
                @elseif($booking->status==='pending') <span class="bs-pending">⏳ Pending</span>
                @else <span class="bs-cancelled">✗ Rejected</span>
                @endif
            </div>

            {{-- Section: Contact --}}
            <div class="mb-3 pb-1" style="border-bottom:2px solid #f1f5f9;">
                <div style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#94a3b8;margin-bottom:0.75rem;">
                    Customer Contact
                </div>
                <table class="table table-borderless mb-0" style="font-size:0.875rem;">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:32%;font-size:0.8rem;">Full Name</td>
                        <td class="fw-semibold">{{ $booking->full_name ?? $booking->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Email</td>
                        <td>{{ $booking->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Phone</td>
                        <td>{{ $booking->phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Registered As</td>
                        <td>{{ $booking->user->name }} (account)</td>
                    </tr>
                </table>
            </div>

            {{-- Section: Event Details --}}
            <div class="mb-3 pb-1" style="border-bottom:2px solid #f1f5f9;">
                <div style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#94a3b8;margin-bottom:0.75rem;">
                    Event Details
                </div>
                <table class="table table-borderless mb-0" style="font-size:0.875rem;">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:32%;font-size:0.8rem;">Event</td>
                        <td class="fw-semibold">{{ $booking->event->title }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Event Date</td>
                        <td>{{ $booking->event->date->format('D, d F Y') }} at {{ \Carbon\Carbon::parse($booking->event->time)->format('g:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Venue</td>
                        <td>{{ $booking->event->venue }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Category</td>
                        <td>{{ $booking->event->category->name }}</td>
                    </tr>
                </table>
            </div>

            {{-- Section: Enquiry Specifics --}}
            <div class="mb-3 pb-1" style="border-bottom:2px solid #f1f5f9;">
                <div style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#94a3b8;margin-bottom:0.75rem;">
                    Enquiry Requirements
                </div>
                <table class="table table-borderless mb-0" style="font-size:0.875rem;">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:32%;font-size:0.8rem;">Preferred Date</td>
                        <td class="fw-semibold">
                            @if($booking->preferred_date)
                                {{ $booking->preferred_date->format('D, d F Y') }}
                            @else — @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Expected Guests</td>
                        <td class="fw-semibold">{{ $booking->expected_guests ? number_format($booking->expected_guests) . ' guests' : '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Theme Preference</td>
                        <td>{{ $booking->theme_preference ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Package</td>
                        <td>
                            @if($booking->package === 'silver')   🥈 <strong>Silver</strong>
                            @elseif($booking->package === 'gold') 🥇 <strong>Gold</strong>
                            @elseif($booking->package === 'premium') 💎 <strong>Premium</strong>
                            @else — @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Estimated Budget</td>
                        <td class="fw-semibold" style="color:#1e40af;">{{ $booking->estimated_budget ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Special Requirements</td>
                        <td>{{ $booking->notes ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="font-size:0.8rem;">Submitted On</td>
                        <td>{{ $booking->created_at->format('D, d M Y, g:i A') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Update Status --}}
            <div>
                <h6 class="fw-bold mb-3" style="font-size:0.85rem;">Update Enquiry Status</h6>
                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="d-flex gap-2 flex-wrap">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select" style="max-width:220px;font-size:0.875rem;border-radius:8px;">
                        <option value="pending"   {{ $booking->status==='pending'   ? 'selected':'' }}>⏳ Pending</option>
                        <option value="confirmed" {{ $booking->status==='confirmed' ? 'selected':'' }}>✓ Approved</option>
                        <option value="cancelled" {{ $booking->status==='cancelled' ? 'selected':'' }}>✗ Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-admin-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar: User Details --}}
    <div class="col-md-4">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:0.85rem;">Account Information</h6>
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-person me-2 text-primary"></i><strong class="text-dark">{{ $booking->user->name }}</strong></div>
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-envelope me-2 text-primary"></i>{{ $booking->user->email }}</div>
            @if($booking->phone)
            <div class="text-muted mb-2" style="font-size:0.83rem;"><i class="bi bi-telephone me-2 text-primary"></i>{{ $booking->phone }}</div>
            @endif
            <hr style="border-color:#f1f5f9;">
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-calendar3 me-2 text-primary"></i>Event on {{ $booking->event->date->format('d M Y') }}</div>
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-grid me-2 text-primary"></i>{{ $booking->event->category->name }}</div>
            @if($booking->preferred_date)
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-calendar-heart me-2 text-primary"></i>Preferred: {{ $booking->preferred_date->format('d M Y') }}</div>
            @endif
            @if($booking->expected_guests)
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-people me-2 text-primary"></i>{{ number_format($booking->expected_guests) }} guests</div>
            @endif
            @if($booking->estimated_budget)
            <div class="text-muted mb-1" style="font-size:0.83rem;"><i class="bi bi-currency-rupee me-2 text-primary"></i>Budget: {{ $booking->estimated_budget }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
