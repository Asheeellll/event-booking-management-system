{{-- Admin: Users List --}}
@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0" style="font-size:0.9rem;color:#0f172a;">Registered Users</h5>
        <div class="text-muted" style="font-size:0.78rem;">{{ $users->total() }} total</div>
    </div>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Bookings</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody class="bg-white">
                @forelse($users as $user)
                <tr>
                    <td class="text-muted" style="font-size:0.78rem;">{{ $user->id }}</td>
                    <td class="fw-semibold" style="font-size:0.84rem;color:#0f172a;">{{ $user->name }}</td>
                    <td class="text-muted" style="font-size:0.82rem;">{{ $user->email }}</td>
                    <td class="text-muted" style="font-size:0.82rem;">{{ $user->phone ?? '—' }}</td>
                    <td>
                        <span style="background:#eff6ff;color:#1e40af;border-radius:4px;padding:0.15rem 0.55rem;font-size:0.72rem;font-weight:600;">
                            {{ $user->bookings_count }}
                        </span>
                    </td>
                    <td class="text-muted" style="font-size:0.78rem;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-act-view">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-act-delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-5 bg-white text-muted">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $users->links() }}</div>
@endsection
