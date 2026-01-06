<?php

namespace App\Http\Controllers;

use App\Models\SportType;
use Illuminate\Http\Request;

class SportTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = SportType::withCount('events');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sportTypes = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.sport_types.index', compact('sportTypes'));
    }

    public function create()
    {
        return view('admin.sport_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sport_types,name',
            'description' => 'nullable|string',
        ]);

        SportType::create($request->all());

        return redirect()->route('admin.sport_types.index')
            ->with('success', 'Sport type created successfully');
    }

    public function edit(SportType $sportType)
    {
        return view('admin.sport_types.edit', compact('sportType'));
    }

    public function update(Request $request, SportType $sportType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sport_types,name,' . $sportType->id,
            'description' => 'nullable|string',
        ]);

        $sportType->update($request->all());

        return redirect()->route('admin.sport_types.index')
            ->with('success', 'Sport type updated successfully');
    }

    public function destroy(SportType $sportType)
    {
        if ($sportType->events()->count() > 0) {
            return redirect()->route('admin.sport_types.index')
                ->with('error', 'Cannot delete sport type with existing events');
        }

        $sportType->delete();

        return redirect()->route('admin.sport_types.index')
            ->with('success', 'Sport type deleted successfully');
    }
}