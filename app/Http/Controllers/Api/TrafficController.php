<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use App\Models\TrafficUpdate;
use App\Models\User;
use App\Notifications\TrafficInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class TrafficController extends Controller
{
    /**
     * Display a listing of traffic updates
     */
    public function index(Request $request)
    {
        $query = TrafficUpdate::with('user');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $updates = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $updates,
        ]);
    }

    /**
     * Store a new traffic update
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'status' => 'required|in:lancar,padat,macet',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('traffic-images', 'public');
        }

        $trafficUpdate = TrafficUpdate::create([
            'user_id' => Auth::id(),
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Notify all civitas and warga users about traffic update
        $usersToNotify = User::whereIn('role', ['civitas', 'warga'])->get();
        Notification::send($usersToNotify, new TrafficInfo($trafficUpdate));

        return response()->json([
            'success' => true,
            'message' => 'Laporan kemacetan berhasil dibuat dan notifikasi telah dikirim!',
            'data' => $trafficUpdate->load('user'),
        ], 201);
    }

    /**
     * Display the specified traffic update
     */
    public function show(TrafficUpdate $trafficUpdate)
    {
        return response()->json([
            'success' => true,
            'data' => $trafficUpdate->load('user'),
        ]);
    }

    /**
     * Update the specified traffic update
     */
    public function update(Request $request, TrafficUpdate $trafficUpdate)
    {
        // Check authorization
        if (Auth::id() !== $trafficUpdate->user_id && !Auth::user()->isAdmin() && !Auth::user()->isSatpam()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $request->validate([
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:lancar,padat,macet',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($trafficUpdate->image) {
                Storage::disk('public')->delete($trafficUpdate->image);
            }
            $trafficUpdate->image = $request->file('image')->store('traffic-images', 'public');
        }

        $trafficUpdate->update($request->only(['location', 'status', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Update lalu lintas berhasil diperbarui!',
            'data' => $trafficUpdate->fresh()->load('user'),
        ]);
    }

    /**
     * Remove the specified traffic update
     */
    public function destroy(TrafficUpdate $trafficUpdate)
    {
        // Check authorization
        if (Auth::id() !== $trafficUpdate->user_id && !Auth::user()->isAdmin() && !Auth::user()->isSatpam()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        if ($trafficUpdate->image) {
            Storage::disk('public')->delete($trafficUpdate->image);
        }

        $trafficUpdate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Update lalu lintas berhasil dihapus!',
        ]);
    }

    /**
     * Get latest traffic updates summary
     */
    public function latestSummary()
    {
        $latest = TrafficUpdate::with('user')
            ->latest()
            ->take(5)
            ->get();

        $summary = [
            'lancar' => TrafficUpdate::where('status', 'lancar')
                ->where('created_at', '>=', now()->subHours(24))
                ->count(),
            'padat' => TrafficUpdate::where('status', 'padat')
                ->where('created_at', '>=', now()->subHours(24))
                ->count(),
            'macet' => TrafficUpdate::where('status', 'macet')
                ->where('created_at', '>=', now()->subHours(24))
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'latest' => $latest,
                'summary_24h' => $summary,
            ],
        ]);
    }
}
