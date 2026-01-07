<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CctvController extends Controller
{
    /**
     * Display public list of CCTVs
     */
    public function index()
    {
        $cctvs = Cctv::where('status', 'online')->get();
        return view('cctv.index', compact('cctvs'));
    }

    /**
     * Display admin list of CCTVs
     */
    public function adminIndex()
    {
        $cctvs = Cctv::all();
        return view('admin.cctv.index', compact('cctvs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.cctv.create');
    }

    /**
     * Store new CCTV
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'stream_url' => 'nullable|string|url',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:online,offline,maintenance',
            'description' => 'nullable|string',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('cctv-thumbnails', 'public');
        }

        Cctv::create([
            'name' => $request->name,
            'location' => $request->location,
            'stream_url' => $request->stream_url,
            'thumbnail' => $thumbnailPath,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.cctv.index')->with('success', 'CCTV berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(Cctv $cctv)
    {
        return view('admin.cctv.edit', compact('cctv'));
    }

    /**
     * Update CCTV
     */
    public function update(Request $request, Cctv $cctv)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'stream_url' => 'nullable|string|url',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:online,offline,maintenance',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($cctv->thumbnail) {
                Storage::disk('public')->delete($cctv->thumbnail);
            }
            $cctv->thumbnail = $request->file('thumbnail')->store('cctv-thumbnails', 'public');
        }

        $cctv->update([
            'name' => $request->name,
            'location' => $request->location,
            'stream_url' => $request->stream_url,
            'thumbnail' => $cctv->thumbnail,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.cctv.index')->with('success', 'CCTV berhasil diperbarui!');
    }

    /**
     * Delete CCTV
     */
    public function destroy(Cctv $cctv)
    {
        if ($cctv->thumbnail) {
            Storage::disk('public')->delete($cctv->thumbnail);
        }

        $cctv->delete();

        return redirect()->route('admin.cctv.index')->with('success', 'CCTV berhasil dihapus!');
    }
}
