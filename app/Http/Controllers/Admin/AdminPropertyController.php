<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPropertyController extends Controller
{
    /**
     * Display admin properties dashboard
     */
    public function index()
    {
        $admin = Auth::user();

        $properties = Property::where('user_id', $admin->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Property::where('user_id', $admin->id)->count(),

            'vacant' => Property::where('user_id', $admin->id)
                ->where('status', 'vacant')
                ->count(),

            'occupied' => Property::where('user_id', $admin->id)
                ->where('status', 'occupied')
                ->count(),
        ];

        return view('admin.adminhome', compact(
            'admin',
            'properties',
            'stats'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.properties.create');
    }

    /**
     * Store property
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:vacant,occupied',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        Property::create($validated);

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Property $property)
    {
        $this->authorizeProperty($property);

        return view('admin.properties.edit', compact('property'));
    }

    /**
     * Update property
     */
    public function update(Request $request, Property $property)
    {
        $this->authorizeProperty($property);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:vacant,occupied',
            'price' => 'required|numeric|min:0',
        ]);

        $property->update($validated);

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Delete property
     */
    public function destroy(Property $property)
    {
        $this->authorizeProperty($property);

        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    /**
     * Ensure admin owns property
     */
    private function authorizeProperty(Property $property)
    {
        if ($property->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}