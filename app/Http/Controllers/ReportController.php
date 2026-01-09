<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $reports = Report::with('user')->latest()->get();
        } else {
            $reports = Report::with('user')->where('user_id', Auth::id())->latest()->get();
        }
        return view('reports.index', compact('reports'));
    }

    /**
     * Show report form.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat!');
    }

    /**
     * Update report status (Admin only)
     */
    public function updateStatus(Request $request, Report $report)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,validated,in_progress,completed,rejected'
        ]);

        $report->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status laporan diperbarui!',
                'status' => $report->status,
            ]);
        }

        return back()->with('success', 'Status laporan diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Cek otorisasi: owner atau admin
        if (Auth::id() !== $report->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Hapus gambar jika ada
        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }

        // Hapus data
        $report->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dihapus.'
            ]);
        }

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
