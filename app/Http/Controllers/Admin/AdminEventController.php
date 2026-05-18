<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ADMIN EVENT CONTROLLER
 * -----------------------
 * Full CRUD for events by admin.
 * Uses Laravel's resource controller pattern.
 */
class AdminEventController extends Controller
{
    /** List all events */
    public function index()
    {
        $events = Event::with(['category', 'user'])->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /** Show create event form */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /** Save new event */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'date'        => ['required', 'date', 'after_or_equal:today'],
            'time'        => ['required'],
            'venue'       => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event created successfully!');
    }

    /** Show single event — redirects to edit (admin doesn't need a read-only detail view) */
    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event);
    }

    /** Show edit form */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /** Update existing event */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'date'        => ['required', 'date'],
            'time'        => ['required'],
            'venue'       => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0'],
            'status'      => ['required', 'in:active,cancelled'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('image');

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event updated successfully!');
    }

    /** Delete an event */
    public function destroy(Event $event)
    {
        // Delete image from storage if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event deleted successfully!');
    }
}
