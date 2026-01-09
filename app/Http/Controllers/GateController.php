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
        $gates = Gate::latest()->get();
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
            'nama_gerbang' => 'required|string|max:255',
            'traffic_status' => 'required|in:lancar,padat,macet',
            'status' => 'required|in:open,closed',
            'cctv_url' => 'nullable|string|url',
        ]);

        Gate::create([
            'nama_gerbang' => $request->nama_gerbang,
            'status' => $request->status,
            'traffic_status' => $request->traffic_status,
            'cctv_url' => $request->cctv_url,
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
            'nama_gerbang' => 'required|string|max:255',
            'traffic_status' => 'required|in:lancar,padat,macet',
            'status' => 'required|in:open,closed',
            'cctv_url' => 'nullable|url',
        ]);

        $gate->update([
            'nama_gerbang' => $request->nama_gerbang,
            'status' => $request->status,
            'traffic_status' => $request->traffic_status,
            'cctv_url' => $request->cctv_url,
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
