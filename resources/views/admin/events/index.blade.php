{{-- Admin: Events List --}}
@extends('layouts.admin')
@section('title', 'Events')
@section('page-title', 'Manage Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0" style="color:#0f172a;font-size:0.9rem;">All Events</h5>
        <div class="text-muted" style="font-size:0.78rem;">{{ $events->total() }} total</div>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Event
    </a>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Event</th><th>Category</th><th>Date</th><th>Price</th><th>Seats</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($events as $event)
                <tr>
                    <td class="text-muted" style="font-size:0.78rem;">{{ $event->id }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.84rem;color:#0f172a;">{{ Str::limit($event->title, 42) }}</div>
                        <div class="text-muted" style="font-size:0.72rem;"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($event->venue, 32) }}</div>
                    </td>
                    <td>
                        <span style="background:#eff6ff;color:#1e40af;border-radius:4px;padding:0.15rem 0.5rem;font-size:0.72rem;font-weight:600;">
                            {{ $event->category->name }}
                        </span>
                    </td>
                    <td style="font-size:0.82rem;">
                        {{ $event->date->format('d M Y') }}<br>
                        <span class="text-muted" style="font-size:0.72rem;">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                    </td>
                    <td class="fw-semibold" style="font-size:0.84rem;">
                        @if($event->isFree()) <span style="color:#15803d;">Free</span>
                        @else <span style="color:#1e40af;">₹{{ number_format($event->price) }}</span>
                        @endif
                    </td>
                    <td style="font-size:0.82rem;">
                        {{ $event->availableSeats() }} left<br>
                        <span class="text-muted" style="font-size:0.72rem;">of {{ $event->capacity }}</span>
                    </td>
                    <td>
                        @if($event->status==='active') <span class="bs-active">Active</span>
                        @else <span class="bs-cancelled">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn-act-edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-act-delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 bg-white text-muted">
                        No events found.
                        <a href="{{ route('admin.events.create') }}" style="color:#2563eb;">Create one →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $events->links() }}</div>
@endsection
