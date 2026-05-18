<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * EVENT CONTROLLER (Public)
 * -------------------------
 * Handles public event browsing pages.
 * - index: List all active events (with optional search/filter)
 * - show: View a single event in detail
 */
class EventController extends Controller
{
    /**
     * Display list of all active events.
     * Supports filtering by category and search by title.
     */
    public function index(Request $request)
    {
        $query = Event::where('status', 'active')->with('category');

        // Filter by category if selected
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events     = $query->latest()->paginate(9); // 9 per page (3×3 grid)
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display a single event's details.
     * Uses route model binding: Laravel automatically finds the Event by ID.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
