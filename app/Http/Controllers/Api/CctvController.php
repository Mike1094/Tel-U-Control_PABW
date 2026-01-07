<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CctvController extends Controller
{
    /**
     * Display a listing of all CCTVs
     */
    public function index(Request $request)
    {
        $query = Cctv::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $cctvs = $query->get();

        return response()->json([
            'success' => true,
            'data' => $cctvs,
        ]);
    }

    /**
     * Store a newly created CCTV
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'stream_url' => 'nullable|string|url',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'sometimes|in:online,offline,maintenance',
            'description' => 'nullable|string',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('cctv-thumbnails', 'public');
        }

        $cctv = Cctv::create([
            'name' => $request->name,
            'location' => $request->location,
            'stream_url' => $request->stream_url,
            'thumbnail' => $thumbnailPath,
            'status' => $request->status ?? 'online',
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'CCTV berhasil ditambahkan!',
            'data' => $cctv,
        ], 201);
    }

    /**
     * Display the specified CCTV
     */
    public function show(Cctv $cctv)
    {
        return response()->json([
            'success' => true,
            'data' => $cctv,
        ]);
    }

    /**
     * Update the specified CCTV
     */
    public function update(Request $request, Cctv $cctv)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'stream_url' => 'nullable|string|url',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'sometimes|in:online,offline,maintenance',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($cctv->thumbnail) {
                Storage::disk('public')->delete($cctv->thumbnail);
            }
            $cctv->thumbnail = $request->file('thumbnail')->store('cctv-thumbnails', 'public');
        }

        $cctv->update($request->only(['name', 'location', 'stream_url', 'status', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'CCTV berhasil diperbarui!',
            'data' => $cctv->fresh(),
        ]);
    }

    /**
     * Update CCTV status
     */
    public function updateStatus(Request $request, Cctv $cctv)
    {
        $request->validate([
            'status' => 'required|in:online,offline,maintenance',
        ]);

        $cctv->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status CCTV berhasil diperbarui!',
            'data' => $cctv->fresh(),
        ]);
    }

    /**
     * Remove the specified CCTV
     */
    public function destroy(Cctv $cctv)
    {
        if ($cctv->thumbnail) {
            Storage::disk('public')->delete($cctv->thumbnail);
        }

        $cctv->delete();

        return response()->json([
            'success' => true,
            'message' => 'CCTV berhasil dihapus!',
        ]);
    }

    /**
     * Get CCTVs summary
     */
    public function summary()
    {
        $cctvs = Cctv::all();

        $summary = [
            'total' => $cctvs->count(),
            'online' => $cctvs->where('status', 'online')->count(),
            'offline' => $cctvs->where('status', 'offline')->count(),
            'maintenance' => $cctvs->where('status', 'maintenance')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'cctvs' => $cctvs,
                'summary' => $summary,
            ],
        ]);
    }
}
