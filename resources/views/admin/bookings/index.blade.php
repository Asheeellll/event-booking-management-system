{{-- Admin: Manage Enquiries (admin/bookings/index.blade.php) --}}
@extends('layouts.admin')
@section('title', 'Enquiries')
@section('page-title', 'Manage Enquiries')

@section('content')

{{-- Search & Filter Bar --}}
<div class="form-card mb-4" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.25rem;">
    <form method="GET" action="{{ route('admin.bookings.index') }}">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1" style="font-size:0.78rem;color:#475569;">Search</label>
                <input type="text" name="search" class="form-control" style="font-size:0.875rem;border-color:#e2e8f0;border-radius:8px;padding:0.5rem 0.85rem;"
                       placeholder="Customer name, email, or event..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1" style="font-size:0.78rem;color:#475569;">Status</label>
                <select name="status" class="form-select" style="font-size:0.875rem;border-color:#e2e8f0;border-radius:8px;padding:0.5rem 0.85rem;">
                    <option value="">All Status</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Approved</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary flex-fill" style="font-size:0.875rem;">
                    <i class="bi bi-search me-1"></i> Search
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:0.875rem;" title="Clear filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0" style="font-size:0.9rem;color:#0f172a;">All Enquiries</h5>
        <div class="text-muted" style="font-size:0.78rem;">{{ $bookings->total() }} total
            @if(request('search') || request('status')) — filtered @endif
        </div>
    </div>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Event</th>
                    <th>Package</th>
                    <th>Budget</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($bookings as $b)
                <tr>
                    <td class="text-muted" style="font-size:0.78rem;">#{{ $b->id }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.83rem;">{{ $b->full_name ?? $b->user->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">{{ $b->user->email }}</div>
                        @if($b->phone)
                            <div class="text-muted" style="font-size:0.72rem;"><i class="bi bi-telephone me-1"></i>{{ $b->phone }}</div>
                        @endif
                    </td>
                    <td style="font-size:0.83rem;font-weight:500;">{{ Str::limit($b->event->title, 28) }}</td>
                    <td>
                        @if($b->package === 'silver')   <span class="bs-confirmed" style="background:#f1f5f9;color:#475569;border-color:#cbd5e1;">🥈 Silver</span>
                        @elseif($b->package === 'gold') <span class="bs-confirmed" style="background:#fefce8;color:#a16207;border-color:#fde047;">🥇 Gold</span>
                        @elseif($b->package === 'premium') <span class="bs-confirmed" style="background:#faf5ff;color:#7c3aed;border-color:#d8b4fe;">💎 Premium</span>
                        @else <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.82rem;color:#475569;">{{ $b->estimated_budget ?? '—' }}</td>
                    <td class="fw-semibold text-center">{{ $b->expected_guests ?? '—' }}</td>
                    <td>
                        {{-- DB: pending/confirmed/cancelled → UI: Pending/Approved/Rejected --}}
                        @if($b->status==='confirmed') <span class="bs-confirmed">✓ Approved</span>
                        @elseif($b->status==='pending') <span class="bs-pending">⏳ Pending</span>
                        @else <span class="bs-cancelled">✗ Rejected</span>
                        @endif
                    </td>
                    <td class="text-muted" style="font-size:0.78rem;">{{ $b->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 align-items-center">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="btn-act-view" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{-- Approve (confirm) --}}
                            @if($b->status !== 'confirmed')
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn-act-edit" title="Approve"><i class="bi bi-check-lg"></i></button>
                            </form>
                            @endif
                            {{-- Reject (cancel) --}}
                            @if($b->status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn-act-delete" title="Reject"><i class="bi bi-x-lg"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-5 bg-white text-muted">
                    <i class="bi bi-chat-dots" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:0.5rem;"></i>
                    No enquiries found.
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $bookings->links() }}</div>
@endsection
