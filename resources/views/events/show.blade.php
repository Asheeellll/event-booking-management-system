{{-- EVENT DETAIL PAGE (events/show.blade.php) --}}
@extends('layouts.app')
@section('title', $event->title)

@section('styles')
<style>
    .page-hero { background:#0f172a; padding:2.25rem 0 2.25rem; border-bottom:1px solid rgba(255,255,255,0.05); }
    .breadcrumb-link { color:rgba(255,255,255,0.45); text-decoration:none; font-size:0.82rem; }
    .breadcrumb-link:hover { color:rgba(255,255,255,0.8); }

    .detail-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; }
    .event-hero-img { height:260px; background:#1e293b; display:flex; align-items:center; justify-content:center; }
    .event-hero-img i { font-size:5rem; color:rgba(255,255,255,0.12); }

    .info-box { display:flex; align-items:flex-start; gap:0.75rem; padding:0.85rem 1rem;
                background:#f8fafc; border:1px solid #f1f5f9; border-radius:10px; }
    .info-box-icon { width:36px; height:36px; border-radius:8px; background:#eff6ff;
                     display:flex; align-items:center; justify-content:center;
                     color:#2563eb; font-size:0.9rem; flex-shrink:0; }
    .info-label { font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:#94a3b8; }
    .info-value { font-size:0.875rem; font-weight:600; color:#0f172a; }

    .booking-sidebar { background:#fff; border:1px solid #e2e8f0; border-radius:12px;
                       position:sticky; top:80px; overflow:hidden; }
    .sidebar-header { background:#0f172a; padding:1.25rem; }
    .price-display { font-size:2rem; font-weight:800; color:#fff; line-height:1; }
    .price-sub { font-size:0.78rem; color:rgba(255,255,255,0.5); margin-top:2px; }
    .sidebar-body { padding:1.25rem; }
    .seats-progress { height:6px; border-radius:6px; background:#f1f5f9; overflow:hidden; }
    .seats-progress .bar { height:100%; border-radius:6px; background:#2563eb; }
    .btn-book-now {
        display:block; width:100%; padding:0.75rem;
        background:#1e40af; color:#fff; border:none; border-radius:8px;
        font-weight:700; font-size:0.9rem; text-align:center;
        text-decoration:none; transition:background 0.15s;
    }
    .btn-book-now:hover { background:#1e3a8a; color:#fff; }
    .btn-book-now.disabled { background:#cbd5e1; cursor:not-allowed; }
    .cat-badge { display:inline-block; background:#eff6ff; color:#1e40af; font-size:0.72rem;
                 font-weight:700; border-radius:4px; padding:0.2rem 0.6rem; }
    .status-cancelled { display:inline-block; background:#fef2f2; color:#dc2626;
                        font-size:0.72rem; font-weight:700; border-radius:4px; padding:0.2rem 0.6rem;
                        border:1px solid #fecaca; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <span><a href="{{ route('events.index') }}" class="breadcrumb-link">Events</a></span>
            <span style="color:rgba(255,255,255,0.25);margin:0 0.5rem;">/</span>
            <span style="color:rgba(255,255,255,0.6);font-size:0.82rem;">{{ Str::limit($event->title, 45) }}</span>
        </nav>
        <div class="d-flex flex-wrap gap-2 mb-2">
            <span class="cat-badge">{{ $event->category->name }}</span>
            @if($event->status === 'cancelled') <span class="status-cancelled">Cancelled</span> @endif
            @if($event->isFree()) <span style="background:#f0fdf4;color:#16a34a;font-size:0.72rem;font-weight:700;border-radius:4px;padding:0.2rem 0.6rem;border:1px solid #bbf7d0;">Free Event</span> @endif
        </div>
        <h1 class="text-white fw-bold mb-0" style="font-size:clamp(1.3rem,3vw,1.8rem);">{{ $event->title }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        {{-- LEFT: Details --}}
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="event-hero-img">
                    @if($event->image)
                        <img src="{{ asset('storage/'.$event->image) }}" style="width:100%;height:260px;object-fit:cover;" alt="{{ $event->title }}">
                    @else
                        @php $icons=['Technology'=>'bi-laptop','Music'=>'bi-music-note-beamed','Sports'=>'bi-trophy','Business'=>'bi-briefcase','Education'=>'bi-mortarboard']; @endphp
                        <i class="bi {{ $icons[$event->category->name] ?? 'bi-calendar-event' }}"></i>
                    @endif
                </div>
                <div class="p-4">
                    <h5 class="fw-bold mb-3" style="color:#0f172a;font-size:1rem;">Event Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-icon"><i class="bi bi-calendar-date"></i></div>
                                <div>
                                    <div class="info-label">Date</div>
                                    <div class="info-value">{{ $event->date->format('l, d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-icon"><i class="bi bi-clock"></i></div>
                                <div>
                                    <div class="info-label">Time</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-icon"><i class="bi bi-geo-alt"></i></div>
                                <div>
                                    <div class="info-label">Venue</div>
                                    <div class="info-value">{{ $event->venue }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <div class="info-box-icon"><i class="bi bi-people"></i></div>
                                <div>
                                    <div class="info-label">Capacity</div>
                                    <div class="info-value">{{ $event->capacity }} total seats</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="border-color:#f1f5f9;">
                    <h5 class="fw-bold mb-3 mt-3" style="color:#0f172a;font-size:1rem;">About This Event</h5>
                    <p style="color:#475569;line-height:1.8;font-size:0.9rem;">{{ $event->description }}</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Booking Sidebar --}}
        <div class="col-lg-4">
            <div class="booking-sidebar">
                <div class="sidebar-header">
                    @if($event->isFree())
                        <div class="price-display" style="color:#4ade80;">Free</div>
                        <div class="price-sub">No charges for this event</div>
                    @else
                        <div style="color:rgba(255,255,255,0.5);font-size:0.72rem;margin-bottom:2px;">Ticket Price</div>
                        <div class="price-display">₹{{ number_format($event->price) }}</div>
                        <div class="price-sub">per person</div>
                    @endif
                </div>
                <div class="sidebar-body">
                    @php
                        $booked = $event->bookedTickets();
                        $avail  = $event->availableSeats();
                        $pct    = $event->capacity > 0 ? min(100, round(($booked/$event->capacity)*100)) : 0;
                    @endphp
                    <div class="mb-1 d-flex justify-content-between" style="font-size:0.78rem;color:#64748b;">
                        <span>Seats booked</span>
                        <span class="fw-semibold" style="color:#0f172a;">{{ $booked }}/{{ $event->capacity }}</span>
                    </div>
                    <div class="seats-progress mb-1">
                        <div class="bar" style="width:{{ $pct }}%;"></div>
                    </div>
                    <div class="mb-4" style="font-size:0.75rem;color:#94a3b8;">{{ $avail }} seats remaining</div>

                    <div class="mb-4 p-3" style="background:#f8fafc;border-radius:8px;font-size:0.8rem;color:#64748b;">
                        <div class="mb-1"><i class="bi bi-calendar3 me-1 text-primary"></i>{{ $event->date->format('d M Y') }}, {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</div>
                        <div><i class="bi bi-geo-alt me-1 text-primary"></i>{{ Str::limit($event->venue, 45) }}</div>
                    </div>

                    @if($event->status === 'cancelled')
                        <button class="btn-book-now disabled" disabled>Event Cancelled</button>
                    @elseif($avail <= 0)
                        <button class="btn-book-now disabled" disabled>Sold Out</button>
                    @elseif(auth()->check())
                        <a href="{{ route('bookings.create', $event) }}" class="btn-book-now">
                            Book Now <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-book-now">Sign In to Book</a>
                        <p class="text-center mt-2 mb-0" style="font-size:0.78rem;color:#94a3b8;">
                            New here? <a href="{{ route('register') }}" style="color:#2563eb;">Register free</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
