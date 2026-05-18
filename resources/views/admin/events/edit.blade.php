{{-- Admin: Edit Event Form --}}
@extends('layouts.admin')
@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.events.index') }}" style="color:#666;text-decoration:none;font-size:0.88rem;">
        <i class="bi bi-arrow-left me-1"></i>Back to Events
    </a>
</div>

<div class="form-card">
    <h5 class="fw-bold mb-4" style="color:#1a1a2e;">
        <i class="bi bi-pencil-square me-2 text-danger"></i>Edit: {{ Str::limit($event->title, 50) }}
    </h5>

    {{--
        PUT request via method spoofing (@method('PUT'))
        because HTML forms only support GET and POST natively.
    --}}
    <form method="POST"
          action="{{ route('admin.events.update', $event) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $event->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                                {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Venue <span class="text-danger">*</span></label>
                <input type="text" name="venue"
                       class="form-control @error('venue') is-invalid @enderror"
                       value="{{ old('venue', $event->venue) }}" required>
                @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                <input type="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Time <span class="text-danger">*</span></label>
                <input type="time" name="time"
                       class="form-control @error('time') is-invalid @enderror"
                       value="{{ old('time', substr($event->time, 0, 5)) }}" required>
                @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Capacity <span class="text-danger">*</span></label>
                <input type="number" name="capacity"
                       class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity', $event->capacity) }}" min="1" required>
                @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Price (PKR) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">PKR</span>
                    <input type="number" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $event->price) }}" min="0" step="0.01" required>
                </div>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status"
                        class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active"    {{ old('status', $event->status) === 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Replace Image</label>
                <input type="file" name="image"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                @if($event->image)
                    <div class="form-text">
                        <i class="bi bi-image me-1 text-success"></i>
                        Current image: {{ basename($event->image) }}
                    </div>
                @else
                    <div class="form-text">No current image.</div>
                @endif
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="5" required>{{ old('description', $event->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>

        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-admin-primary px-4">
                <i class="bi bi-check-circle me-2"></i>Save Changes
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>
@endsection
