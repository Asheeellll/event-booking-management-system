{{-- BOOKING FORM (bookings/create.blade.php) --}}
@extends('layouts.app')
@section('title', 'Book — ' . $event->title)

@section('styles')
<style>
    .page-hero { background:#0f172a; padding:2.25rem 0; border-bottom:1px solid rgba(255,255,255,0.05); }
    .breadcrumb-link { color:rgba(255,255,255,0.45); text-decoration:none; font-size:0.82rem; }
    .form-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:2rem; }
    .step-num { width:26px;height:26px;border-radius:50%;background:#1e40af;color:#fff;
                display:inline-flex;align-items:center;justify-content:center;
                font-size:0.72rem;font-weight:700;flex-shrink:0; }
    .step-label { font-weight:700; font-size:0.875rem; color:#0f172a; }
    .form-label { font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:0.3rem; }
    .form-control, .form-select {
        font-size:0.875rem; border-color:#e2e8f0; border-radius:8px;
        padding:0.55rem 0.85rem; transition:border-color 0.15s,box-shadow 0.15s;
    }
    .form-control:focus, .form-select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.1); }

    .summary-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; position:sticky; top:80px; }
    .summary-header { background:#0f172a; padding:1.15rem 1.25rem; }
    .summary-thumb { height:130px; background:#1e293b; display:flex; align-items:center; justify-content:center; }
    .summary-thumb i { font-size:3rem; color:rgba(255,255,255,0.12); }
    .summary-body { padding:1.15rem 1.25rem; }
    .price-row { display:flex; justify-content:space-between; font-size:0.825rem; color:#64748b; padding:0.45rem 0; border-bottom:1px dashed #f1f5f9; }
    .price-row:last-of-type { border:none; }
    .total-row { display:flex; justify-content:space-between; font-size:0.95rem; font-weight:700; color:#0f172a; padding-top:0.5rem; }
    .total-amount { color:#1e40af; }

    .btn-confirm {
        display:block; width:100%; padding:0.7rem;
        background:#1e40af; color:#fff; border:none; border-radius:8px;
        font-weight:700; font-size:0.9rem; transition:background 0.15s; cursor:pointer;
    }
    .btn-confirm:hover { background:#1e3a8a; }
    .form-check-input:checked { background-color:#1e40af; border-color:#1e40af; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <nav class="mb-3">
            <a href="{{ route('events.show', $event) }}" class="breadcrumb-link">
                <i class="bi bi-arrow-left me-1"></i>{{ Str::limit($event->title, 40) }}
            </a>
        </nav>
        <h1 class="text-white fw-bold mb-0" style="font-size:1.4rem;">Book Tickets</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- FORM --}}
        <div class="col-lg-8">
            <div class="form-card">
                {{-- Event summary banner --}}
                <div class="d-flex gap-3 p-3 mb-4 rounded-3 align-items-center"
                     style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <i class="bi bi-calendar-event" style="font-size:1.8rem;color:#2563eb;flex-shrink:0;"></i>
                    <div>
                        <div class="fw-bold" style="color:#0f172a;font-size:0.9rem;">{{ $event->title }}</div>
                        <div style="font-size:0.78rem;color:#64748b;margin-top:2px;">
                            <i class="bi bi-calendar3 me-1"></i>{{ $event->date->format('d M Y') }}
                            &middot; <i class="bi bi-geo-alt ms-1 me-1"></i>{{ Str::limit($event->venue, 40) }}
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    {{-- Step 1: Tickets --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">1</span>
                            <span class="step-label">Number of Tickets</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Quantity</label>
                                <select name="tickets" id="ticketCount"
                                        class="form-select @error('tickets') is-invalid @enderror"
                                        onchange="updatePrice()">
                                    @php $maxTickets = min(10, $event->availableSeats()); @endphp
                                    @for($i=1; $i<=$maxTickets; $i++)
                                        <option value="{{ $i }}" {{ old('tickets',1)==$i ? 'selected':'' }}>
                                            {{ $i }} {{ $i==1 ? 'Ticket' : 'Tickets' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('tickets') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8 d-flex align-items-end">
                                <div class="w-100 p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                                    @if($event->isFree())
                                        <div style="font-size:0.82rem;color:#1e40af;font-weight:600;">
                                            <i class="bi bi-gift me-1"></i> This is a free event — no payment needed.
                                        </div>
                                    @else
                                        <div style="font-size:0.78rem;color:#475569;">
                                            ₹{{ number_format($event->price) }} × <span id="ticketCountDisplay">1</span> ticket(s)
                                        </div>
                                        <div style="font-size:1.1rem;font-weight:700;color:#1e40af;margin-top:3px;">
                                            Total: <span id="totalDisplay">₹{{ number_format($event->price) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Notes --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">2</span>
                            <span class="step-label">Special Notes <span class="fw-normal text-muted" style="font-size:0.8rem;">(Optional)</span></span>
                        </div>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                  rows="3" maxlength="500"
                                  placeholder="Any special requirements or messages...">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Step 3: Confirm --}}
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">3</span>
                            <span class="step-label">Confirm &amp; Submit</span>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" required>
                            <label class="form-check-label" for="agree" style="font-size:0.82rem;color:#64748b;">
                                I confirm that the booking details are correct.
                            </label>
                        </div>
                        <button type="submit" class="btn-confirm">
                            Confirm Booking <i class="bi bi-check2 ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="col-lg-4">
            <div class="summary-card">
                <div class="summary-thumb">
                    @php $icons=['Technology'=>'bi-laptop','Music'=>'bi-music-note-beamed','Sports'=>'bi-trophy','Business'=>'bi-briefcase','Education'=>'bi-mortarboard']; @endphp
                    <i class="bi {{ $icons[$event->category->name] ?? 'bi-calendar-event' }}"></i>
                </div>
                <div class="summary-body">
                    <div class="fw-bold mb-1" style="color:#0f172a;font-size:0.9rem;">{{ Str::limit($event->title,45) }}</div>
                    <div style="font-size:0.78rem;color:#64748b;margin-bottom:1rem;">
                        <i class="bi bi-calendar3 me-1"></i>{{ $event->date->format('d M Y') }}
                    </div>
                    <div class="price-row"><span>Price per ticket</span><span>@if($event->isFree()) Free @else ₹{{ number_format($event->price) }} @endif</span></div>
                    <div class="price-row"><span>Tickets</span><span id="summaryCount">1</span></div>
                    <div class="total-row"><span>Total</span><span class="total-amount" id="summaryTotal">@if($event->isFree()) Free @else ₹{{ number_format($event->price) }} @endif</span></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
const price = {{ $event->price }};
const isFree = {{ $event->isFree() ? 'true' : 'false' }};

function updatePrice() {
    const n = parseInt(document.getElementById('ticketCount').value);
    if (document.getElementById('ticketCountDisplay')) document.getElementById('ticketCountDisplay').textContent = n;
    if (document.getElementById('summaryCount')) document.getElementById('summaryCount').textContent = n;
    if (!isFree) {
        const t = '₹' + (n * price).toLocaleString('en-IN');
        if (document.getElementById('totalDisplay')) document.getElementById('totalDisplay').textContent = t;
        if (document.getElementById('summaryTotal')) document.getElementById('summaryTotal').textContent = t;
    }
}
</script>
@endsection
