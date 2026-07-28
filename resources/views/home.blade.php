{{--
    HOME PAGE (home.blade.php)
    ---------------------------
    Event Management Company — Enquiry Portal
    Sections: Hero | Stats | Featured Events | How It Works
--}}
@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Premier event management company in India. Weddings, corporates, concerts & more. Send an enquiry today.')

@section('styles')
<style>
    /* ── Hero ─────────────────────────────────────────────────── */
    .hero-section {
        background: linear-gradient(135deg, #F8FAFC 0%, #EEF4FF 50%, #E0EAFF 100%);
        padding: 5.5rem 0 4.5rem;
        position: relative;
        overflow: hidden;
    }
    .hero-label {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(37,99,235,0.1);
        border: 1px solid rgba(37,99,235,0.2);
        color: #2563EB; border-radius: 6px;
        padding: 0.3rem 1rem; font-size: 0.72rem;
        font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; margin-bottom: 1.5rem;
    }
    .hero-title {
        font-size: clamp(2.2rem, 5vw, 3.4rem);
        font-weight: 900; color: #0F172A; line-height: 1.15;
        letter-spacing: -1px;
    }
    .hero-title .accent { color: #2563EB; }

    .hero-subtitle {
        color: #475569; font-size: 1.05rem;
        max-width: 540px; line-height: 1.75; margin-top: 1.1rem;
    }

    /* ── Stats Bar ─────────────────────────────────────────────── */
    .stats-strip {
        background: linear-gradient(90deg, #0F172A, #1E3A8A);
        border-top: 1px solid rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding: 1.5rem 0;
    }
    .stat-item { text-align: center; }
    .stat-number { font-size: 1.85rem; font-weight: 900; color: #FFFFFF; line-height: 1; }
    .stat-label  { font-size: 0.78rem; color: rgba(255,255,255,0.8); margin-top: 4px; letter-spacing: 0.3px; }
    .stat-divider { width: 1px; background: rgba(255,255,255,0.15); }

    /* ── Section headings ───────────────────────────────────────── */
    .section-eyebrow {
        font-size: 0.72rem; font-weight: 800; letter-spacing: 2px;
        text-transform: uppercase; color: #2563eb; margin-bottom: 0.4rem;
    }
    .section-title {
        font-size: 1.85rem; font-weight: 800;
        color: #0f172a; letter-spacing: -0.5px;
    }

    /* ── Event Cards ────────────────────────────────────────────── */
    .event-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow 0.25s, transform 0.25s;
        height: 100%;
    }
    .event-card:hover {
        box-shadow: 0 12px 32px rgba(15,23,42,0.12);
        transform: translateY(-4px);
    }
    .event-thumb {
        height: 185px; background: #1e293b;
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }
    .event-thumb i { font-size: 3.2rem; color: rgba(255,255,255,0.12); }
    .event-thumb .cat-pill {
        position: absolute; top: 12px; left: 12px;
        background: rgba(15,23,42,0.75); backdrop-filter: blur(4px);
        color: #93c5fd; font-size: 0.68rem; font-weight: 700;
        border-radius: 4px; padding: 0.22rem 0.65rem; letter-spacing: 0.5px;
    }
    .event-thumb .enquiry-pill {
        position: absolute; top: 12px; right: 12px;
        background: #2563eb; color: #fff;
        font-size: 0.68rem; font-weight: 700;
        border-radius: 4px; padding: 0.22rem 0.65rem;
    }
    .event-card .card-body { padding: 1.3rem; }
    .event-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; line-height: 1.4; margin-bottom: 0.5rem; }
    .event-meta  { font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 0.3rem; }
    .event-price { font-size: 0.85rem; font-weight: 700; color: #1e40af; }
    .event-seats { font-size: 0.73rem; color: #94a3b8; }

    .btn-view {
        font-size: 0.8rem; font-weight: 700;
        background: #eff6ff; color: #1e40af;
        border: 1px solid #bfdbfe; border-radius: 8px;
        padding: 0.4rem 0.95rem; transition: all 0.2s;
        text-decoration: none; display: inline-block;
    }
    .btn-view:hover { background: #1e40af; color: #fff; border-color: #1e40af; }

    /* ── How It Works ───────────────────────────────────────────── */
    .how-section { background: #f1f5f9; }
    .how-card {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 16px; padding: 2rem 1.75rem; text-align: center;
        transition: box-shadow 0.25s, transform 0.25s;
    }
    .how-card:hover {
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        transform: translateY(-3px);
    }
    .how-icon {
        width: 60px; height: 60px; border-radius: 16px;
        background: #eff6ff;
        display: flex; align-items: center;
        justify-content: center; margin: 0 auto 1.25rem;
        font-size: 1.5rem; color: #2563eb;
    }
    .how-step {
        font-size: 0.68rem; font-weight: 800; letter-spacing: 2px;
        color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem;
    }

    /* ── Services chips ──────────────────────────────────────────── */
    .service-chip {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: #FFFFFF; border: 1px solid #E2E8F0;
        border-radius: 6px; padding: 0.35rem 0.85rem;
        font-size: 0.8rem; font-weight: 600; color: #475569;
        transition: all 0.2s;
    }
    .service-chip:hover { background: #EEF4FF; border-color: #2563EB; color: #1D4ED8; }
    .service-chip i { color: #2563EB; }

    /* ── Hero CTA buttons ───────────────────────────────────────── */
    .btn-hero-primary {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #2563EB; color: #fff;
        border: none; border-radius: 8px;
        padding: 0.75rem 1.75rem; font-weight: 700; font-size: 0.95rem;
        text-decoration: none; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }
    .btn-hero-primary:hover { background: #1D4ED8; color: #fff;
        box-shadow: 0 6px 18px rgba(37,99,235,0.35); }
    .btn-hero-secondary {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #FFFFFF; color: #2563EB;
        border: 1px solid #2563EB; border-radius: 8px;
        padding: 0.75rem 1.75rem; font-weight: 600; font-size: 0.95rem;
        text-decoration: none; transition: all 0.2s;
    }
    .btn-hero-secondary:hover { background: #F8FAFC; color: #1D4ED8; border-color: #1D4ED8; }
</style>
@endsection

@section('content')

{{-- ═══ HERO ═══════════════════════════════════════════════════════ --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="hero-label">
                    <i class="bi bi-stars"></i> India's Premier Event Company
                </div>
                <h1 class="hero-title">
                    We Create
                    <span class="accent">Unforgettable</span><br>
                    Event Experiences
                </h1>
                <p class="hero-subtitle">
                    From grand weddings and corporate galas to music festivals and private celebrations — we plan, manage, and deliver flawless events across India.
                </p>

                {{-- Services chips --}}
                <div class="d-flex flex-wrap gap-2 mt-3 mb-4">
                    <span class="service-chip"><i class="bi bi-heart-fill"></i> Weddings</span>
                    <span class="service-chip"><i class="bi bi-briefcase-fill"></i> Corporate</span>
                    <span class="service-chip"><i class="bi bi-music-note-beamed"></i> Concerts</span>
                    <span class="service-chip"><i class="bi bi-balloon-fill"></i> Private Events</span>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('events.index') }}" class="btn-hero-primary">
                        <i class="bi bi-calendar3"></i> Explore Events
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="btn-hero-secondary">
                        <i class="bi bi-chat-dots"></i> Get Free Quote
                    </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                {{-- Feature highlight cards --}}
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#FFFFFF;border:1px solid #E2E8F0;box-shadow:0 12px 30px rgba(15,23,42,0.08);">
                            <div class="d-flex align-items-center mb-2 gap-2">
                                <div style="background:#2563EB;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div class="fw-bold" style="font-size:1.5rem;color:#0F172A;">500+</div>
                            </div>
                            <div style="color:#2563EB;font-size:0.85rem;font-weight:600;">Events Managed</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#FFFFFF;border:1px solid #E2E8F0;box-shadow:0 12px 30px rgba(15,23,42,0.08);">
                            <div class="d-flex align-items-center mb-2 gap-2">
                                <div style="background:#2563EB;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-map"></i>
                                </div>
                                <div class="fw-bold" style="font-size:1.5rem;color:#0F172A;">15+</div>
                            </div>
                            <div style="color:#2563EB;font-size:0.85rem;font-weight:600;">Cities Covered</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#FFFFFF;border:1px solid #E2E8F0;box-shadow:0 12px 30px rgba(15,23,42,0.08);">
                            <div class="d-flex align-items-center mb-2 gap-2">
                                <div style="background:#2563EB;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="fw-bold" style="font-size:1.5rem;color:#0F172A;">10+</div>
                            </div>
                            <div style="color:#2563EB;font-size:0.85rem;font-weight:600;">Years Experience</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#FFFFFF;border:1px solid #E2E8F0;box-shadow:0 12px 30px rgba(15,23,42,0.08);">
                            <div class="d-flex align-items-center mb-2 gap-2">
                                <div style="background:#2563EB;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="fw-bold" style="font-size:1.5rem;color:#0F172A;">{{ $events->count() }}+</div>
                            </div>
                            <div style="color:#2563EB;font-size:0.85rem;font-weight:600;">Active Events</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#FFFFFF;border:1px solid #E2E8F0;box-shadow:0 12px 30px rgba(15,23,42,0.08);">
                            <div style="color:#475569;font-size:0.78rem;margin-bottom:0.4rem;font-weight:600;">
                                <i class="bi bi-calendar-event me-1" style="color:#2563EB;"></i>Featured Event
                            </div>
                            <div class="fw-bold" style="font-size:1rem;color:#0F172A;">
                                {{ $events->first()?->title ?? 'Coming Soon' }}
                            </div>
                            @if($events->first())
                            <div style="color:#64748B;font-size:0.8rem;margin-top:0.25rem;">
                                <i class="bi bi-calendar3 me-1" style="color:#2563EB;"></i>
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
                <div class="stat-number">500+</div>
                <div class="stat-label">Events Managed</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Happy Clients</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">15+</div>
                <div class="stat-label">Cities</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="px-4 py-1 stat-item flex-fill">
                <div class="stat-number">10+</div>
                <div class="stat-label">Years Experience</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ FEATURED EVENTS ══════════════════════════════════════════════ --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col">
                <div class="section-eyebrow">Our Portfolio</div>
                <h2 class="section-title mb-0">Upcoming Events</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('events.index') }}"
                   style="font-size:0.875rem;color:#6366f1;text-decoration:none;font-weight:700;">
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
                        <span class="enquiry-pill"><i class="bi bi-chat-dots me-1"></i>Enquire</span>
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
                                    <span class="event-price" style="color:#16a34a;">Complimentary</span>
                                @else
                                    <span class="event-price">Starting from ₹{{ number_format($event->price) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('events.show', $event) }}" class="btn-view">View Details</a>
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
               style="border-radius:10px;border-color:#6366f1;color:#6366f1;">
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
            <h2 class="section-title">How We Work</h2>
            <p class="text-muted mt-2" style="font-size:0.9rem;max-width:480px;margin:0 auto;">
                From your first enquiry to the final applause — we handle every detail.
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 position-relative">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-search"></i></div>
                    <div class="how-step">Step 01</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">Browse Events</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.7;">
                        Explore our portfolio of events by category or theme. Find the one that matches your vision.
                    </p>
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-chat-dots"></i></div>
                    <div class="how-step">Step 02</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">Send an Enquiry</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.7;">
                        Fill in a quick form with your requirements — date, guests, budget, and theme. No commitment needed.
                    </p>
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <div class="how-card">
                    <div class="how-icon"><i class="bi bi-stars"></i></div>
                    <div class="how-step">Step 03</div>
                    <h5 class="fw-bold mb-2" style="color:#0f172a;">We Plan & Deliver</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.7;">
                        Our expert team crafts a custom proposal and manages everything — so you just enjoy the event.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
