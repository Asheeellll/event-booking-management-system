{{-- EVENT LISTING PAGE (events/index.blade.php) --}}
@extends('layouts.app')
@section('title', 'Browse Events')
@section('description', 'Browse all upcoming events across India and book your tickets.')

@section('styles')
<style>
    .page-hero { background:#0f172a; padding:2.5rem 0 3.5rem; border-bottom:1px solid rgba(255,255,255,0.05); }
    .filter-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px;
                   box-shadow:0 1px 3px rgba(0,0,0,0.06); padding:1.25rem; margin-top:-2rem; position:relative; z-index:10; }
    .form-control, .form-select {
        font-size:0.875rem; border-color:#e2e8f0; border-radius:8px; padding:0.55rem 0.85rem;
    }
    .form-control:focus, .form-select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
    .btn-search {
        background:#1e40af; color:#fff; border:none; border-radius:8px;
        font-weight:600; font-size:0.875rem; padding:0.55rem 1.25rem; transition:background 0.15s;
    }
    .btn-search:hover { background:#1e3a8a; color:#fff; }

    .event-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px;
                  overflow:hidden; height:100%; transition:box-shadow 0.2s, transform 0.2s; }
    .event-card:hover { box-shadow:0 6px 20px rgba(15,23,42,0.09); transform:translateY(-3px); }
    .event-thumb { height:175px; background:#1e293b; display:flex; align-items:center;
                   justify-content:center; position:relative; }
    .event-thumb i { font-size:3rem; color:rgba(255,255,255,0.15); }
    .cat-pill { position:absolute; top:10px; left:10px; background:rgba(15,23,42,0.72);
                backdrop-filter:blur(4px); color:#93c5fd; font-size:0.68rem; font-weight:600;
                border-radius:4px; padding:0.18rem 0.5rem; }
    .free-pill { position:absolute; top:10px; right:10px; background:#16a34a; color:#fff;
                 font-size:0.68rem; font-weight:700; border-radius:4px; padding:0.18rem 0.5rem; }
    .cancelled-ribbon { position:absolute; bottom:0; left:0; right:0; background:rgba(220,38,38,0.85);
                        text-align:center; color:#fff; font-size:0.72rem; font-weight:600; padding:0.2rem; }
    .card-body { padding:1.15rem; }
    .event-title { font-size:0.9rem; font-weight:700; color:#0f172a; line-height:1.4; margin-bottom:0.4rem; }
    .event-desc  { font-size:0.78rem; color:#64748b; line-height:1.55; margin-bottom:0.75rem; }
    .meta-line   { font-size:0.76rem; color:#64748b; display:flex; align-items:center; gap:0.3rem; margin-bottom:0.25rem; }
    .event-price { font-size:1.05rem; font-weight:700; color:#1e40af; }
    .seats-label { font-size:0.72rem; color:#94a3b8; }
    .btn-details { font-size:0.78rem; font-weight:600; background:#eff6ff; color:#1e40af;
                   border:1px solid #bfdbfe; border-radius:6px; padding:0.3rem 0.8rem;
                   text-decoration:none; transition:all 0.15s; }
    .btn-details:hover { background:#1e40af; color:#fff; border-color:#1e40af; }
    .page-link { color:#1e40af; } .page-item.active .page-link { background:#1e40af; border-color:#1e40af; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white fw-bold mb-1" style="font-size:1.6rem;">Browse Events</h1>
        <p style="color:rgba(255,255,255,0.5);font-size:0.875rem;margin:0;">
            Find and book from upcoming events across India
        </p>
    </div>
</div>

<div class="container py-4">

    {{-- FILTER --}}
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('events.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold mb-1" style="font-size:0.78rem;color:#475569;">Search</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Event name, city, keyword..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold mb-1" style="font-size:0.78rem;color:#475569;">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-search flex-fill">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:0.875rem;">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <p class="text-muted mb-3" style="font-size:0.82rem;">
        Showing <strong style="color:#0f172a;">{{ $events->total() }}</strong> event(s)
        @if(request('search')) for &ldquo;<strong>{{ request('search') }}</strong>&rdquo; @endif
    </p>

    @php
        $icons  = ['Technology'=>'bi-laptop','Music'=>'bi-music-note-beamed','Sports'=>'bi-trophy','Business'=>'bi-briefcase','Education'=>'bi-mortarboard'];
        $colors = ['Technology'=>'#1e293b','Music'=>'#1a1535','Sports'=>'#0c2340','Business'=>'#1c2432','Education'=>'#192231'];
    @endphp

    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-sm-6 col-lg-4">
            <div class="event-card">
                <div class="event-thumb" style="background:{{ $colors[$event->category->name] ?? '#1e293b' }};">
                    @if($event->image)
                        <img src="{{ asset('storage/'.$event->image) }}" style="width:100%;height:175px;object-fit:cover;" alt="{{ $event->title }}">
                    @else
                        <i class="bi {{ $icons[$event->category->name] ?? 'bi-calendar-event' }}"></i>
                    @endif
                    <span class="cat-pill">{{ $event->category->name }}</span>
                    @if($event->isFree()) <span class="free-pill">FREE</span> @endif
                    @if($event->status === 'cancelled') <div class="cancelled-ribbon">Cancelled</div> @endif
                </div>
                <div class="card-body">
                    <div class="event-title">{{ $event->title }}</div>
                    <p class="event-desc">{{ Str::limit($event->description, 85) }}</p>
                    <div class="meta-line"><i class="bi bi-calendar3"></i> {{ $event->date->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</div>
                    <div class="meta-line mb-3"><i class="bi bi-geo-alt"></i> {{ Str::limit($event->venue, 40) }}</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @if($event->isFree())
                                <div class="event-price" style="color:#16a34a;">Free</div>
                            @else
                                <div class="event-price">₹{{ number_format($event->price) }}</div>
                            @endif
                            <div class="seats-label"><i class="bi bi-people me-1"></i>{{ $event->availableSeats() }} seats</div>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="btn-details">Details</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;">
                <i class="bi bi-calendar-x" style="font-size:3rem;color:#cbd5e1;"></i>
                <h5 class="mt-3" style="color:#334155;">No events found</h5>
                <p class="text-muted" style="font-size:0.875rem;">Try a different search term or category.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" style="border-radius:7px;">Clear Filters</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $events->appends(request()->query())->links() }}
    </div>
</div>
@endsection
