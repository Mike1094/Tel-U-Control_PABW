<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    /**
     * Display list of gates (Admin)
     */
    public function index()
    {
        $gates = Gate::with('lastUpdatedBy')->get();
        return view('admin.gates.index', compact('gates'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.gates.create');
    }

    /**
     * Store new gate
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:lancar,padat,macet,tutup',
        ]);

        Gate::create([
            'name' => $request->name,
            'status' => $request->status,
            'is_open' => $request->status !== 'tutup',
            'last_updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.gates.index')->with('success', 'Gate berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(Gate $gate)
    {
        return view('admin.gates.edit', compact('gate'));
    }

    /**
     * Update gate
     */
    public function update(Request $request, Gate $gate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:lancar,padat,macet,tutup',
        ]);

        $gate->update([
            'name' => $request->name,
            'status' => $request->status,
            'is_open' => $request->status !== 'tutup',
            'last_updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.gates.index')->with('success', 'Gate berhasil diperbarui!');
    }

    /**
     * Delete gate
     */
    public function destroy(Gate $gate)
    {
        $gate->delete();

        return redirect()->route('admin.gates.index')->with('success', 'Gate berhasil dihapus!');
    }
}
