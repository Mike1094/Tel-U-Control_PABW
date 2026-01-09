<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use App\Models\TrafficUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrafficController extends Controller
{
    public function index()
    {
        $gates = Gate::latest()->get();
        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(20)->get();
        return view('traffic.index', compact('gates', 'trafficUpdates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'status' => 'required|in:lancar,padat,macet',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('traffic-images', 'public');
        }

        TrafficUpdate::create([
            'user_id' => Auth::id(),
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Update lalu lintas berhasil dikirim!');
    }

    public function updateGate(Request $request, Gate $gate)
    {
        $request->validate([
            'traffic_status' => 'required|in:lancar,padat,macet',
        ]);

        $gate->update([
            'traffic_status' => $request->traffic_status,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status gerbang diperbarui!',
                'new_status' => $gate->traffic_status,
            ]);
        }

        return back()->with('success', 'Status gerbang diperbarui!');
    }
}
