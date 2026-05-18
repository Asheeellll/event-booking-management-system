{{-- Admin: Create Event Form --}}
@extends('layouts.admin')
@section('title', 'Create Event')
@section('page-title', 'Create New Event')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.events.index') }}" style="color:#666;text-decoration:none;font-size:0.88rem;">
        <i class="bi bi-arrow-left me-1"></i>Back to Events
    </a>
</div>

<div class="form-card">
    <h5 class="fw-bold mb-4" style="color:#1a1a2e;">
        <i class="bi bi-calendar-plus me-2 text-danger"></i>New Event Details
    </h5>

    {{--
        POST to AdminEventController@store
        enctype="multipart/form-data" required for file (image) upload
    --}}
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

            {{-- Event Title --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="e.g. AI Summit 2025"
                       required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Category --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Venue --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Venue <span class="text-danger">*</span></label>
                <input type="text" name="venue"
                       class="form-control @error('venue') is-invalid @enderror"
                       value="{{ old('venue') }}"
                       placeholder="e.g. Pearl Continental Hotel, Karachi">
                @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Date --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                <input type="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date') }}"
                       min="{{ date('Y-m-d') }}" required>
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Time --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Time <span class="text-danger">*</span></label>
                <input type="time" name="time"
                       class="form-control @error('time') is-invalid @enderror"
                       value="{{ old('time') }}" required>
                @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Capacity --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Capacity <span class="text-danger">*</span></label>
                <input type="number" name="capacity"
                       class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity') }}"
                       placeholder="e.g. 200" min="1" required>
                @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Price --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ticket Price (PKR) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">PKR</span>
                    <input type="number" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', 0) }}"
                           placeholder="0 for free event" min="0" step="0.01" required>
                </div>
                <div class="form-text">Set to 0 for a free event.</div>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Image Upload --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Event Image</label>
                <input type="file" name="image"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                <div class="form-text">Optional. Max 2MB. JPEG/PNG.</div>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="5"
                          placeholder="Write a detailed description of the event..."
                          required>{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-admin-primary px-4">
                <i class="bi bi-check-circle me-2"></i>Create Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
