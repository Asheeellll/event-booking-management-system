{{--
    HOME PAGE (home.blade.php)
    ---------------------------
    Sections: Hero | Stats | Featured Events | How It Works
    Design: Professional blue palette, clean cards, no flashy effects.
--}}
@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Discover and book the best events across India.')

@section('styles')
<style>
    /* ── Hero ─────────────────────────────────────────────────── */
    .hero-section {
        background: #0f172a;
        padding: 5rem 0 4rem;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute; top: 0; right: 0;
        width: 50%; height: 100%;
        background: radial-gradient(ellipse at right center, rgba(37,99,235,0.15) 0%, transparent 65%);
        pointer-events: none;
    }
    .hero-label {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(96,165,250,0.1);
        border: 1px solid rgba(96,165,250,0.25);
        color: #93c5fd; border-radius: 4px;
        padding: 0.25rem 0.75rem; font-size: 0.75rem;
        font-weight: 600; letter-spacing: 1px;
        text-transform: uppercase; margin-bottom: 1.25rem;
    }
    .hero-title {
        font-size: clamp(2rem, 4.5vw, 3rem);
        font-weight: 800; color: #fff; line-height: 1.2;
        letter-spacing: -0.5px;
    }
    .hero-title .accent { color: #60a5fa; }
    .hero-subtitle {
        color: rgba(255,255,255,0.55); font-size: 1rem;
        max-width: 520px; line-height: 1.7; margin-top: 1rem;
    }

    /* ── Stats Bar ─────────────────────────────────────────────── */
    .stats-strip {
        background: #1e293b;
        border-top: 1px solid rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding: 1.25rem 0;
    }
    .stat-item { text-align: center; }
    .stat-number { font-size: 1.75rem; font-weight: 800; color: #60a5fa; line-height: 1; }
    .stat-label  { font-size: 0.78rem; color: rgba(255,255,255,0.5); margin-top: 3px; }
    .stat-divider { width: 1px; background: rgba(255,255,255,0.08); }

    /* ── Section headings ───────────────────────────────────────── */
    .section-eyebrow {
        font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #2563eb; margin-bottom: 0.4rem;
    }
    .section-title {
        font-size: 1.75rem; font-weight: 700;
        color: #0f172a; letter-spacing: -0.3px;
    }

    /* ── Event Cards ────────────────────────────────────────────── */
    .event-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
        height: 100%;
    }
    .event-card:hover {
        box-shadow: 0 8px 25px rgba(15,23,42,0.1);
        transform: translateY(-3px);
    }
    .event-thumb {
        height: 180px; background: #1e293b;
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }
    .event-thumb i { font-size: 3rem; color: rgba(255,255,255,0.15); }
    .event-thumb .cat-pill {
        position: absolute; top: 12px; left: 12px;
        background: rgba(15,23,42,0.7); backdrop-filter: blur(4px);
        color: #93c5fd; font-size: 0.7rem; font-weight: 600;
        border-radius: 4px; padding: 0.2rem 0.55rem; letter-spacing: 0.5px;
    }
    .event-thumb .free-pill {
        position: absolute; top: 12px; right: 12px;
        background: #16a34a; color: #fff;
        font-size: 0.7rem; font-weight: 700;
        border-radius: 4px; padding: 0.2rem 0.55rem;
    }
    .event-card .card-body { padding: 1.25rem; }
    .event-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; line-height: 1.4; margin-bottom: 0.5rem; }
    .event-meta  { font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 0.3rem; }
    .event-price { font-size: 1.1rem; font-weight: 700; color: #1e40af; }
    .event-seats { font-size: 0.73rem; color: #94a3b8; }

    .btn-view {
        font-size: 0.8rem; font-weight: 600;
        background: #eff6ff; color: #1e40af;
        border: 1px solid #bfdbfe; border-radius: 6px;
        padding: 0.35rem 0.85rem; transition: all 0.15s;
        text-decoration: none; display: inline-block;
    }
    .btn-view:hover { background: #1e40af; color: #fff; border-color: #1e40af; }

    /* ── How It Works ───────────────────────────────────────────── */
    .how-section { background: #f1f5f9; }
    .how-card {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 12px; padding: 1.75rem 1.5rem; text-align: center;
        transition: box-shadow 0.2s;
    }
    .how-card:hover { box-shadow: 0 4px 15px rgba(15,23,42,0.07); }
    .how-icon {
        width: 56px; height: 56px; border-radius: 12px;
        background: #eff6ff; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 1rem;
        font-size: 1.4rem; color: #2563eb;
    }
    .how-step {
        font-size: 0.7rem; font-weight: 700; letter-spacing: 1px;
        color: #94a3b8; text-transform: uppercase; margin-bottom: 0.4rem;
    }
</style>
@endsection

@section('content')

{{-- ═══ HERO ═══════════════════════════════════════════════════════ --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="hero-label">
                    <i class="bi bi-geo-alt-fill"></i> Events Across India
                </div>
                <h1 class="hero-title">
                    Book tickets to <br>
                    <span class="accent">India's best events</span>
                </h1>
                <p class="hero-subtitle">
                    From tech conferences in Bengaluru to music festivals in Pune — discover, compare, and book in one place.
                </p>
                <div class="d-flex gap-3 flex-wrap mt-4">
                    <a href="{{ route('events.index') }}"
                       class="btn btn-primary fw-semibold px-4 py-2"
                       style="background:#2563eb;border-color:#2563eb;border-radius:8px;">
                        Browse Events
                    </a>
                    @guest
                    <a href="{{ route('register') }}"
                       class="btn fw-semibold px-4 py-2"
                       style="background:rgba(255,255,255,0.08);color:#fff;border:1px solid rgba(255,255,255,0.2);border-radius:8px;">
                        Create Free Account
                    </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                {{-- Feature highlight cards --}}
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);">
                            <div class="fw-bold text-white mb-1" style="font-size:1.4rem;">{{ $events->count() }}+</div>
                            <div style="color:rgba(255,255,255,0.5);font-size:0.8rem;">Active Events</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:rgba(37,99,235,0.2);border:1px solid rgba(37,99,235,0.3);">
                            <div class="fw-bold text-white mb-1" style="font-size:1.4rem;">5</div>
                            <div style="color:rgba(255,255,255,0.5);font-size:0.8rem;">Categories</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
                            <div style="color:rgba(255,255,255,0.6);font-size:0.8rem;margin-bottom:0.5rem;">Next Featured Event</div>
                            <div class="fw-semibold text-white" style="font-size:0.95rem;">
                                {{ $events->first()->title ?? 'Coming Soon' }}
                            </div>
                            @if($events->first())
                            <div style="color:#60a5fa;font-size:0.78rem;margin-top:0.25rem;">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $events->first()->date->format('d M Y') }}
                                &middot;
                                {{ Str::limit($events->first()->venue, 30) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ STATS STRIP ═════════════════════════════════════════════════ --}}
<div class="stats-strip">
    <div class="container">
        <div class="d-flex justify-content-center align-items-stretch gap-0">
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">{{ $events->count() }}+</div>
                <div class="stat-label">Upcoming Events</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">5</div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">6+</div>
                <div class="stat-label">Cities Covered</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">100%</div>
                <div class="stat-label">Secure Booking</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ FEATURED EVENTS ══════════════════════════════════════════════ --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col">
                <div class="section-eyebrow">Featured</div>
                <h2 class="section-title mb-0">Upcoming Events</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('events.index') }}"
                   style="font-size:0.875rem;color:#2563eb;text-decoration:none;font-weight:600;">
                    View all <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        @php
            $thumbIcons = [
                'Technology' => 'bi-laptop',
                'Music'      => 'bi-music-note-beamed',
                'Sports'     => 'bi-trophy',
                'Business'   => 'bi-briefcase',
                'Education'  => 'bi-mortarboard',
            ];
            $thumbColors = [
                'Technology' => '#1e293b',
                'Music'      => '#1a1535',
                'Sports'     => '#0c2340',
                'Business'   => '#1c2432',
                'Education'  => '#192231',
            ];
        @endphp

        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-sm-6 col-lg-4">
                <div class="event-card">
                    <div class="event-thumb"
                         style="background:{{ $thumbColors[$event->category->name] ?? '#1e293b' }};">
                        <i class="bi {{ $thumbIcons[$event->category->name] ?? 'bi-calendar-event' }}"></i>
                        <span class="cat-pill">{{ $event->category->name }}</span>
                        @if($event->isFree())
                            <span class="free-pill">FREE</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-meta mb-1">
                            <i class="bi bi-calendar3"></i>
                            {{ $event->date->format('d M Y') }} &middot;
                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                        </div>
                        <div class="event-meta mb-3">
                            <i class="bi bi-geo-alt"></i>
                            {{ Str::limit($event->venue, 42) }}
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                @if($event->isFree())
                                    <span class="event-price" style="color:#16a34a;">Free</span>
                                @else
                                    <span class="event-price">₹{{ number_format($event->price) }}</span>
                                @endif
                                <div class="event-seats">{{ $event->availableSeats() }} seats left</div>
                            </div>
                            <a href="{{ route('events.show', $event) }}" class="btn-view">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-calendar-x" style="font-size:3rem;opacity:0.3;"></i>
                <p class="mt-3">No events available right now. Check back soon.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('events.index') }}"
               class="btn btn-outline-primary px-5 py-2 fw-semibold"
               style="border-radius:8px;">
                Browse All Events
            </a>
        </div>
    </div>
</section>

{{-- ═══ HOW IT WORKS ════════════════════════════════════════════════ --}}
<section class="how-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-eyebrow">Simple Process</div>
            <h2 class="section-title">How EventBook Works</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-search"></i></div>
                    <div class="how-step">Step 01</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">Browse Events</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.6;">
                        Explore events by category, city, or date. Filter to find exactly what you're looking for.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-person-check"></i></div>
                    <div class="how-step">Step 02</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">Register &amp; Sign In</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.6;">
                        Create a free account in seconds. Your bookings are saved securely to your profile.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-check2-circle"></i></div>
                    <div class="how-step">Step 03</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">Confirm Booking</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.6;">
                        Choose your ticket count, review the details, and confirm. That's it — you're in!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
