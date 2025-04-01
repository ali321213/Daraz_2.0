<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the units.
     */
    public function index()
    {
        $units = Unit::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.units.index', compact('units'));
    }

    /**
     * Search for units based on name or symbol.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $units = Unit::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('symbol', 'like', "%$search%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('admin.units.index', compact('units'));
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'description' => 'nullable|string|max:1000',
        ]);

        $unit = Unit::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.units.index')->with('success', 'Unit Added Successfully!');
        // return response()->json(['success' => 'Unit added successfully', 'unit' => $unit]);
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'description' => 'nullable|string|max:1000',
        ]);
        $unit = Unit::findOrFail($id);
        $unit->update([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'description' => $request->description,
        ]);
        // return response()->json(['success' => 'Unit updated successfully', 'unit' => $unit]);
        return redirect()->route('admin.units.index')->with('success', 'Unit Updated Successfully!');
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json(['success' => 'Unit deleted successfully']);
    }
}