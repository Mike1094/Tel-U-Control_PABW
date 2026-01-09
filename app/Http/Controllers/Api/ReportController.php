<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of all reports
     */
    public function index(Request $request)
    {
        $query = Report::with('user');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user (my reports)
        if ($request->boolean('my_reports')) {
            $query->where('user_id', Auth::id());
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Map search to DB columns
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        // Map Indonesian params to DB columns
        if ($sortBy === 'judul') $sortBy = 'title';
        if ($sortBy === 'deskripsi') $sortBy = 'description';
        if ($sortBy === 'lokasi') $sortBy = 'location';
        // Handle direct English param usage too
        if ($sortBy === 'title') $sortBy = 'title';
        
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $reports = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('reports', 'public');
        }

        // Map inputs to DB columns
        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => $request->judul,
            'description' => $request->deskripsi,
            'location' => $request->lokasi,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan kerusakan fasilitas berhasil dibuat!',
            'data' => $report->load('user'),
        ], 201);
    }

    /**
     * Display the specified report
     */
    public function show(Report $report)
    {
        return response()->json([
            'success' => true,
            'data' => $report->load('user'),
        ]);
    }

    /**
     * Update the specified report
     */
    public function update(Request $request, Report $report)
    {
        // Check authorization
        if (Auth::id() !== $report->user_id && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk mengubah laporan ini.',
            ], 403);
        }

        $request->validate([
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'lokasi' => 'sometimes|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'status' => 'sometimes|in:pending,validated,in_progress,completed,rejected',
            'feedback' => 'nullable|string',
        ]);

        // Only admin can update status and feedback
        if (!Auth::user()->isAdmin()) {
            $request->request->remove('status');
            $request->request->remove('feedback');
        }

        $updateData = [];
        if ($request->has('judul')) $updateData['title'] = $request->judul;
        if ($request->has('deskripsi')) $updateData['description'] = $request->deskripsi;
        if ($request->has('lokasi')) $updateData['location'] = $request->lokasi;
        if ($request->has('status')) $updateData['status'] = $request->status;
        if ($request->has('feedback')) $updateData['feedback'] = $request->feedback;

        if ($request->hasFile('foto')) {
            // Delete old image
            if ($report->image) {
                Storage::disk('public')->delete($report->image);
            }
            $updateData['image'] = $request->file('foto')->store('reports', 'public');
        }

        $report->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil diperbarui!',
            'data' => $report->fresh()->load('user'),
        ]);
    }

    /**
     * Update report status (Admin/Satpam only)
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,validated,in_progress,completed,rejected',
            'feedback' => 'nullable|string',
        ]);

        $report->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui!',
            'data' => $report->fresh()->load('user'),
        ]);
    }

    /**
     * Remove the specified report
     */
    public function destroy(Report $report)
    {
        // Check authorization
        if (Auth::id() !== $report->user_id && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk menghapus laporan ini.',
            ], 403);
        }

        // Delete image if exists
        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dihapus!',
        ]);
    }

    /**
     * Get reports statistics (Admin)
     */
    public function statistics()
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'validated' => Report::where('status', 'validated')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'completed' => Report::where('status', 'completed')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
            'this_week' => Report::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => Report::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
