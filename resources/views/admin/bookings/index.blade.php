{{-- Admin: Bookings List --}}
@extends('layouts.admin')
@section('title', 'Bookings')
@section('page-title', 'Manage Bookings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0" style="font-size:0.9rem;color:#0f172a;">All Bookings</h5>
        <div class="text-muted" style="font-size:0.78rem;">{{ $bookings->total() }} total</div>
    </div>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>User</th><th>Event</th><th>Tickets</th><th>Amount</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody class="bg-white">
                @forelse($bookings as $b)
                <tr>
                    <td class="text-muted" style="font-size:0.78rem;">#{{ $b->id }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.83rem;">{{ $b->user->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">{{ $b->user->email }}</div>
                    </td>
                    <td style="font-size:0.83rem;font-weight:500;">{{ Str::limit($b->event->title, 32) }}</td>
                    <td class="fw-semibold text-center">{{ $b->tickets }}</td>
                    <td class="fw-semibold">
                        @if($b->total_price==0) <span style="color:#15803d;">Free</span>
                        @else <span style="color:#1e40af;">₹{{ number_format($b->total_price) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($b->status==='confirmed') <span class="bs-confirmed">Confirmed</span>
                        @elseif($b->status==='pending') <span class="bs-pending">Pending</span>
                        @else <span class="bs-cancelled">Cancelled</span>
                        @endif
                    </td>
                    <td class="text-muted" style="font-size:0.78rem;">{{ $b->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 align-items-center">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="btn-act-view">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{-- Quick confirm --}}
                            @if($b->status==='pending')
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn-act-edit" title="Confirm"><i class="bi bi-check"></i></button>
                            </form>
                            @endif
                            @if($b->status!=='cancelled')
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn-act-delete" title="Cancel"><i class="bi bi-x"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-5 bg-white text-muted">No bookings yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $bookings->links() }}</div>
@endsection
