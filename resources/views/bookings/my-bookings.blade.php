{{-- MY ENQUIRIES (bookings/my-bookings.blade.php) --}}
@extends('layouts.app')
@section('title', 'My Enquiries')

@section('styles')
<style>
    .page-hero { background:#0f172a; padding:2.5rem 0 3.5rem; border-bottom:1px solid rgba(255,255,255,0.05); }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:1.15rem;
                 transition:box-shadow 0.15s; margin-top:-2rem; position:relative; z-index:10; }
    .stat-num  { font-size:1.6rem; font-weight:800; line-height:1; }
    .stat-lbl  { font-size:0.72rem; font-weight:600; color:#94a3b8; margin-top:3px; text-transform:uppercase; letter-spacing:0.5px; }
    .section-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; }
    .enq-table thead { background:#f8fafc; }
    .enq-table thead th { font-size:0.73rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; padding:0.85rem 1rem; border-bottom:2px solid #f1f5f9; border-top:none; }
    .enq-table tbody td { padding:0.85rem 1rem; vertical-align:middle; font-size:0.85rem; border-color:#f8fafc; }
    .enq-table tbody tr:hover { background:#f8fafc; }

    /* Status badges (DB stores pending/confirmed/cancelled; UI shows Pending/Approved/Rejected) */
    .bs-approved  { background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }
    .bs-pending   { background:#fffbeb;color:#b45309;border:1px solid #fde68a;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }
    .bs-rejected  { background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }

    /* Package badges */
    .pkg-silver  { background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }
    .pkg-gold    { background:#fefce8;color:#a16207;border:1px solid #fde047;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }
    .pkg-premium { background:#faf5ff;color:#7c3aed;border:1px solid #d8b4fe;border-radius:6px;padding:0.18rem 0.6rem;font-size:0.72rem;font-weight:700; }

    .btn-withdraw { font-size:0.75rem;font-weight:600;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;padding:0.25rem 0.65rem;transition:all 0.15s; }
    .btn-withdraw:hover { background:#dc2626;color:#fff;border-color:#dc2626; }
    .mobile-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;margin-bottom:0.75rem; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white fw-bold mb-1" style="font-size:1.5rem;">
            <i class="bi bi-chat-dots me-2" style="color:#60a5fa;"></i>My Enquiries
        </h1>
        <p style="color:rgba(255,255,255,0.45);font-size:0.875rem;margin:0;">All your event enquiries in one place</p>
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
                {{-- 'confirmed' in DB = 'Approved' in UI --}}
                <div class="stat-num" style="color:#15803d;">{{ $bookings->where('status','confirmed')->count() }}</div>
                <div class="stat-lbl">Approved</div>
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
                {{-- 'cancelled' in DB = 'Rejected' in UI --}}
                <div class="stat-num" style="color:#dc2626;">{{ $bookings->where('status','cancelled')->count() }}</div>
                <div class="stat-lbl">Rejected</div>
            </div>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center py-5 section-card">
            <i class="bi bi-chat-dots" style="font-size:3rem;color:#cbd5e1;"></i>
            <h5 class="mt-3" style="color:#334155;">No enquiries yet</h5>
            <p class="text-muted" style="font-size:0.875rem;">Browse our events and send your first enquiry.</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" style="border-radius:7px;">Browse Events</a>
        </div>
    @else
        {{-- Desktop table --}}
        <div class="section-card d-none d-md-block">
            <table class="table table-hover enq-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Preferred Date</th>
                        <th>Guests</th>
                        <th>Package</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                    <tr>
                        <td class="text-muted" style="font-size:0.8rem;">#{{ $b->id }}</td>
                        <td>
                            <a href="{{ route('events.show', $b->event) }}" style="color:#0f172a;font-weight:600;text-decoration:none;">{{ Str::limit($b->event->title, 35) }}</a>
                            <div style="font-size:0.73rem;color:#94a3b8;"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($b->event->venue, 28) }}</div>
                        </td>
                        <td class="text-muted">
                            @if($b->preferred_date)
                                {{ $b->preferred_date->format('d M Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $b->expected_guests ?? '—' }}</td>
                        <td>
                            @if($b->package === 'silver')   <span class="pkg-silver">🥈 Silver</span>
                            @elseif($b->package === 'gold') <span class="pkg-gold">🥇 Gold</span>
                            @elseif($b->package === 'premium') <span class="pkg-premium">💎 Premium</span>
                            @else <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status==='confirmed') <span class="bs-approved">✓ Approved</span>
                            @elseif($b->status==='pending') <span class="bs-pending">⏳ Pending</span>
                            @else <span class="bs-rejected">✗ Rejected</span>
                            @endif
                        </td>
                        <td class="text-muted" style="font-size:0.78rem;">{{ $b->created_at->format('d M Y') }}</td>
                        <td>
                            @if($b->status==='pending')
                            <form method="POST" action="{{ route('bookings.cancel',$b) }}" onsubmit="return confirm('Withdraw this enquiry?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-withdraw">Withdraw</button>
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
                    <span class="fw-semibold" style="color:#0f172a;font-size:0.88rem;">{{ Str::limit($b->event->title, 30) }}</span>
                    @if($b->status==='confirmed') <span class="bs-approved">Approved</span>
                    @elseif($b->status==='pending') <span class="bs-pending">Pending</span>
                    @else <span class="bs-rejected">Rejected</span>
                    @endif
                </div>
                <div style="font-size:0.78rem;color:#64748b;">
                    @if($b->preferred_date)
                        <i class="bi bi-calendar3 me-1"></i>{{ $b->preferred_date->format('d M Y') }} &middot;
                    @endif
                    {{ $b->expected_guests ?? '—' }} guests &middot;
                    @if($b->package) <strong>{{ ucfirst($b->package) }}</strong> @endif
                </div>
                @if($b->status==='pending')
                <form method="POST" action="{{ route('bookings.cancel',$b) }}" onsubmit="return confirm('Withdraw?');" class="mt-2">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-withdraw w-100">Withdraw Enquiry</button>
                </form>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm" style="border-radius:7px;">Send Another Enquiry</a>
        </div>
    @endif
</div>
@endsection
