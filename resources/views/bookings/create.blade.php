{{-- ENQUIRY FORM (bookings/create.blade.php) --}}
@extends('layouts.app')
@section('title', 'Send Enquiry — ' . $event->title)

@section('styles')
<style>
    .page-hero { background: #0f172a; padding:2.5rem 0; border-bottom:1px solid rgba(255,255,255,0.05); }
    .breadcrumb-link { color:rgba(255,255,255,0.45); text-decoration:none; font-size:0.82rem; }
    .breadcrumb-link:hover { color:rgba(255,255,255,0.75); }

    .form-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:2rem; }
    .step-num { width:28px;height:28px;border-radius:50%;background:#1e40af;color:#fff;
                display:inline-flex;align-items:center;justify-content:center;
                font-size:0.72rem;font-weight:800;flex-shrink:0; }
    .step-label { font-weight:700; font-size:0.9rem; color:#0f172a; }

    .form-label { font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:0.3rem; }
    .form-control, .form-select {
        font-size:0.875rem; border-color:#e2e8f0; border-radius:9px;
        padding:0.6rem 0.9rem; transition:border-color 0.15s, box-shadow 0.15s;
    }
    .form-control:focus, .form-select:focus {
        border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12);
    }
    .required-star { color:#e11d48; }

    /* Package cards */
    .pkg-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:0.75rem; }
    .pkg-option { display:none; }
    .pkg-label {
        display:flex; flex-direction:column; align-items:center;
        border:2px solid #e2e8f0; border-radius:12px; padding:1rem 0.75rem;
        cursor:pointer; transition:all 0.2s; text-align:center;
        background:#fff;
    }
    .pkg-label:hover { border-color:#93c5fd; background:#eff6ff; }
    .pkg-option:checked + .pkg-label {
        border-color:#2563eb; background:#eff6ff;
        box-shadow:0 0 0 3px rgba(37,99,235,0.15);
    }
    .pkg-icon { font-size:1.6rem; margin-bottom:0.4rem; }
    .pkg-name { font-size:0.82rem; font-weight:700; color:#0f172a; }
    .pkg-desc { font-size:0.72rem; color:#64748b; margin-top:0.2rem; }

    /* Sidebar */
    .summary-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; position:sticky; top:80px; }
    .summary-header { background:#0f172a; padding:1.25rem; }
    .summary-thumb { height:130px; background:#1e293b; display:flex; align-items:center; justify-content:center; }
    .summary-thumb i { font-size:3rem; color:rgba(255,255,255,0.1); }
    .summary-body { padding:1.25rem; }
    .info-row { display:flex; align-items:flex-start; gap:0.6rem; padding:0.5rem 0;
                border-bottom:1px dashed #f1f5f9; font-size:0.82rem; }
    .info-row:last-child { border:none; }
    .info-row i { color:#2563eb; margin-top:2px; flex-shrink:0; }

    .btn-submit {
        display:block; width:100%; padding:0.8rem;
        background:#1e40af;
        color:#fff; border:none; border-radius:8px;
        font-weight:700; font-size:0.95rem; transition:all 0.2s; cursor:pointer;
        box-shadow:0 4px 12px rgba(30,64,175,0.3);
    }
    .btn-submit:hover { background:#1e3a8a; box-shadow:0 6px 16px rgba(30,64,175,0.4); }
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
        <h1 class="text-white fw-bold mb-0" style="font-size:1.5rem;">
            <i class="bi bi-chat-dots me-2" style="color:#60a5fa;"></i>Send an Enquiry
        </h1>
        <p style="color:rgba(255,255,255,0.45);font-size:0.85rem;margin-top:0.3rem;">
            Fill in your requirements and our team will get back to you with a custom proposal.
        </p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- FORM --}}
        <div class="col-lg-8">
            <div class="form-card">
                {{-- Event banner --}}
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

                <form method="POST" action="{{ route('bookings.store') }}" id="enquiryForm">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    {{-- Step 1: Contact Details --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">1</span>
                            <span class="step-label">Your Contact Details</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="required-star">*</span></label>
                                <input type="text" name="full_name"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name', auth()->user()->name) }}"
                                       placeholder="Your full name" required>
                                @error('full_name') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled
                                       style="background:#f8fafc;color:#64748b;">
                                <div style="font-size:0.72rem;color:#94a3b8;margin-top:4px;">
                                    <i class="bi bi-info-circle me-1"></i>Replies will be sent to this address
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="required-star">*</span></label>
                                <input type="tel" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"
                                       placeholder="+91 98765 43210" required>
                                @error('phone') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Event Requirements --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">2</span>
                            <span class="step-label">Event Requirements</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Preferred Event Date <span class="required-star">*</span></label>
                                <input type="date" name="preferred_date"
                                       class="form-control @error('preferred_date') is-invalid @enderror"
                                       value="{{ old('preferred_date') }}"
                                       min="{{ now()->addDays(1)->format('Y-m-d') }}" required>
                                @error('preferred_date') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expected Guests <span class="required-star">*</span></label>
                                <input type="number" name="expected_guests"
                                       class="form-control @error('expected_guests') is-invalid @enderror"
                                       value="{{ old('expected_guests') }}"
                                       placeholder="e.g. 200" min="1" max="100000" required>
                                @error('expected_guests') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Theme Preference <span class="fw-normal text-muted" style="font-size:0.8rem;">(Optional)</span></label>
                                <input type="text" name="theme_preference"
                                       class="form-control @error('theme_preference') is-invalid @enderror"
                                       value="{{ old('theme_preference') }}"
                                       placeholder="e.g. Royal Garden, Modern Minimal">
                                @error('theme_preference') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estimated Budget <span class="required-star">*</span></label>
                                <input type="text" name="estimated_budget"
                                       class="form-control @error('estimated_budget') is-invalid @enderror"
                                       value="{{ old('estimated_budget') }}"
                                       placeholder="e.g. ₹2L – ₹5L" required>
                                @error('estimated_budget') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Package --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">3</span>
                            <span class="step-label">Select a Package <span class="required-star">*</span></span>
                        </div>
                        @error('package')
                            <div class="alert alert-danger py-2 mb-3" style="font-size:0.82rem;">{{ $message }}</div>
                        @enderror
                        <div class="pkg-grid">
                            {{-- Silver --}}
                            <div>
                                <input type="radio" name="package" value="silver" id="pkg_silver" class="pkg-option"
                                       {{ old('package') === 'silver' ? 'checked' : '' }} required>
                                <label for="pkg_silver" class="pkg-label">
                                    <div class="pkg-icon">🥈</div>
                                    <div class="pkg-name">Silver</div>
                                    <div class="pkg-desc">Essential coverage, great value</div>
                                </label>
                            </div>
                            {{-- Gold --}}
                            <div>
                                <input type="radio" name="package" value="gold" id="pkg_gold" class="pkg-option"
                                       {{ old('package') === 'gold' ? 'checked' : '' }}>
                                <label for="pkg_gold" class="pkg-label">
                                    <div class="pkg-icon">🥇</div>
                                    <div class="pkg-name">Gold</div>
                                    <div class="pkg-desc">Premium services & décor</div>
                                </label>
                            </div>
                            {{-- Premium --}}
                            <div>
                                <input type="radio" name="package" value="premium" id="pkg_premium" class="pkg-option"
                                       {{ old('package') === 'premium' ? 'checked' : '' }}>
                                <label for="pkg_premium" class="pkg-label">
                                    <div class="pkg-icon">💎</div>
                                    <div class="pkg-name">Premium</div>
                                    <div class="pkg-desc">All-inclusive luxury experience</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Step 4: AI Event Planner --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">4</span>
                            <span class="step-label">AI Event Planner</span>
                        </div>
                        <div class="card p-3 shadow-sm border-0 mb-3" style="background:#F8FAFC; border:1px solid #E2E8F0 !important;">
                            <p style="font-size:0.85rem;color:#475569;margin-bottom:0.75rem;">
                                Let our AI generate a custom event plan based on your requirements above.
                            </p>
                            <button type="button" id="btn-generate-ai" class="btn btn-sm" style="background:#2563EB;color:#fff;width:fit-content;font-weight:600;">
                                ✨ Generate with AI
                            </button>
                            <div id="ai-loading" class="mt-3 d-none">
                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                <span class="ms-2" style="font-size:0.85rem;color:#475569;">Generating your plan...</span>
                            </div>
                            <div id="ai-result-container" class="mt-3 d-none">
                                <textarea id="ai-plan-result" class="form-control mb-2" rows="6" readonly style="font-size:0.85rem;background:#fff;"></textarea>
                                <button type="button" id="btn-copy-notes" class="btn btn-sm btn-outline-primary" style="font-size:0.8rem;font-weight:600;">
                                    <i class="bi bi-clipboard me-1"></i>Copy to Notes
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Step 5: Special Requirements --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">5</span>
                            <span class="step-label">Special Requirements <span class="fw-normal text-muted" style="font-size:0.8rem;">(Optional)</span></span>
                        </div>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                  rows="3" maxlength="100000"
                                  placeholder="Any specific needs, dietary requirements, accessibility, or additional notes...">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Step 6: Submit --}}
                    <div class="mb-2">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-num">6</span>
                            <span class="step-label">Submit Your Enquiry</span>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" required>
                            <label class="form-check-label" for="agree" style="font-size:0.82rem;color:#64748b;">
                                I confirm the details are accurate. I understand this is an enquiry and not a confirmed booking.
                            </label>
                        </div>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="bi bi-send me-2"></i>Submit Enquiry
                        </button>
                        <p class="text-center mt-3 mb-0" style="font-size:0.78rem;color:#94a3b8;">
                            <i class="bi bi-shield-check me-1"></i>
                            Your enquiry is reviewed by our team within 24 hours.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        {{-- SUMMARY SIDEBAR --}}
        <div class="col-lg-4">
            <div class="summary-card">
                <div class="summary-thumb">
                    @php $icons=['Technology'=>'bi-laptop','Music'=>'bi-music-note-beamed','Sports'=>'bi-trophy','Business'=>'bi-briefcase','Education'=>'bi-mortarboard']; @endphp
                    <i class="bi {{ $icons[$event->category->name] ?? 'bi-calendar-event' }}"></i>
                </div>
                <div class="summary-header">
                    <div style="color:rgba(255,255,255,0.5);font-size:0.68rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Enquiry For</div>
                    <div class="fw-bold text-white" style="font-size:0.9rem;line-height:1.4;">{{ Str::limit($event->title, 45) }}</div>
                </div>
                <div class="summary-body">
                    <div class="info-row">
                        <i class="bi bi-calendar3"></i>
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Event Date</div>
                            <div style="font-weight:600;color:#0f172a;">{{ $event->date->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Venue</div>
                            <div style="font-weight:600;color:#0f172a;">{{ Str::limit($event->venue, 40) }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <i class="bi bi-tag"></i>
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Category</div>
                            <div style="font-weight:600;color:#0f172a;">{{ $event->category->name }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <i class="bi bi-currency-rupee"></i>
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Pricing</div>
                            <div style="font-weight:600;color:#1e40af;">
                                @if($event->isFree()) Complimentary
                                @else Starting from &#8377;{{ number_format($event->price) }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                        <div style="font-size:0.78rem;color:#1e40af;font-weight:700;margin-bottom:0.5rem;">
                            <i class="bi bi-info-circle me-1"></i>What happens next?
                        </div>
                        <ul style="font-size:0.78rem;color:#64748b;padding-left:1.2rem;margin:0;line-height:1.8;">
                            <li>We review your enquiry within 24h</li>
                            <li>Our team prepares a custom proposal</li>
                            <li>You receive a detailed quote via email</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnGenerate = document.getElementById('btn-generate-ai');
    const loading = document.getElementById('ai-loading');
    const resultContainer = document.getElementById('ai-result-container');
    const resultTextarea = document.getElementById('ai-plan-result');
    const btnCopy = document.getElementById('btn-copy-notes');
    const notesTextarea = document.querySelector('textarea[name="notes"]');
    
    if(btnGenerate) {
        btnGenerate.addEventListener('click', async function() {
            const expectedGuests = document.querySelector('input[name="expected_guests"]').value;
            const estimatedBudget = document.querySelector('input[name="estimated_budget"]').value;
            const themePreference = document.querySelector('input[name="theme_preference"]').value;
            const pkgElement = document.querySelector('input[name="package"]:checked');
            const pkg = pkgElement ? pkgElement.value : '';
            const csrfToken = document.querySelector('input[name="_token"]').value;

            if (!expectedGuests || !estimatedBudget || !pkg) {
                alert('Please fill out Expected Guests, Estimated Budget, and select a Package first.');
                return;
            }

            btnGenerate.disabled = true;
            loading.classList.remove('d-none');
            resultContainer.classList.add('d-none');

            try {
                const response = await fetch('/ai/event-plan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        event_title: "{!! addslashes($event->title) !!}",
                        expected_guests: expectedGuests,
                        estimated_budget: estimatedBudget,
                        package: pkg,
                        theme_preference: themePreference
                    })
                });

                if (!response.ok) {
                    throw new Error('API request failed');
                }

                const data = await response.json();
                
                resultTextarea.value = data.plan || data.message || 'Plan generated successfully.';
                resultContainer.classList.remove('d-none');
            } catch (error) {
                alert('Failed to generate AI plan. Please try again.');
                console.error(error);
            } finally {
                btnGenerate.disabled = false;
                loading.classList.add('d-none');
            }
        });
    }

    if(btnCopy) {
        btnCopy.addEventListener('click', function() {
            const plan = resultTextarea.value;
            if (plan) {
                const currentNotes = notesTextarea.value;
                notesTextarea.value = currentNotes ? currentNotes + '\n\n--- AI Event Plan ---\n' + plan : '--- AI Event Plan ---\n' + plan;
                alert('Plan copied to notes successfully!');
            }
        });
    }
});
</script>
@endsection
