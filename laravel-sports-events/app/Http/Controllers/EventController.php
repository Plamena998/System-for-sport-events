<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SportType;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Public event listing for regular users
    public function index(Request $request)
    {
        $query = Event::with(['sportType', 'organizer']);

        // Search by event date
        if ($request->filled('event_date')) {
            $query->whereDate('event_date', $request->event_date);
        }

        // Search by organizer
        if ($request->filled('organizer_id')) {
            $query->where('organizer_id', $request->organizer_id);
        }

        // Search by sport type
        if ($request->filled('sport_type_id')) {
            $query->where('sport_type_id', $request->sport_type_id);
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(12)->withQueryString();
        $organizers = Organizer::orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();

        return view('events.index', compact('events', 'organizers', 'sportTypes'));
    }

    // Admin event listing with management options
    public function adminIndex(Request $request)
    {
        $query = Event::with(['sportType', 'organizer']);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Search by event date
        if ($request->filled('event_date')) {
            $query->whereDate('event_date', $request->event_date);
        }

        // Search by organizer
        if ($request->filled('organizer_id')) {
            $query->where('organizer_id', $request->organizer_id);
        }

        // Search by sport type
        if ($request->filled('sport_type_id')) {
            $query->where('sport_type_id', $request->sport_type_id);
        }

        // Sorting
        $allowedSorts = ['name', 'event_date', 'duration'];
        if ($request->filled('sort') && in_array($request->sort, $allowedSorts)) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('event_date', 'asc');
        }

        $events = $query->paginate(10)->withQueryString();
        $organizers = Organizer::orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();

        return view('admin.events.index', compact('events', 'organizers', 'sportTypes'));
    }

    public function create()
    {
        $sportTypes = SportType::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        return view('admin.events.create', compact('sportTypes', 'organizers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'sport_type_id' => 'required|exists:sport_types,id',
            'organizer_id' => 'required|exists:organizers,id',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    public function edit(Event $event)
    {
        $sportTypes = SportType::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'sportTypes', 'organizers'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'sport_type_id' => 'required|exists:sport_types,id',
            'organizer_id' => 'required|exists:organizers,id',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($event->photo_path) {
                Storage::disk('public')->delete($event->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        // Delete photo if exists
        if ($event->photo_path) {
            Storage::disk('public')->delete($event->photo_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}