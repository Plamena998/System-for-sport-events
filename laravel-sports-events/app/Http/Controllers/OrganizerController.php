<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $query = Organizer::withCount('events');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $organizers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Organizer::create($request->all());

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer created successfully');
    }

    public function edit(Organizer $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, Organizer $organizer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizers,email,' . $organizer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $organizer->update($request->all());

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer updated successfully');
    }

    public function destroy(Organizer $organizer)
    {
        if ($organizer->events()->count() > 0) {
            return redirect()->route('admin.organizers.index')
                ->with('error', 'Cannot delete organizer with existing events');
        }

        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer deleted successfully');
    }
}