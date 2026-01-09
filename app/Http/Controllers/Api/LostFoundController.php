<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LostFoundItem;
use App\Models\User;
use App\Notifications\ItemFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class LostFoundController extends Controller
{
    /**
     * Display a listing of lost/found items
     */
    public function index(Request $request)
    {
        $query = LostFoundItem::with('user');

        // Filter by type (jenis: hilang/ditemukan)
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show only open and pending items
            $query->whereIn('status', ['open', 'pending', 'claimed']);
        }

        // Filter by user (my items)
        if ($request->boolean('my_items')) {
            $query->where('user_id', Auth::id());
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi_ditemukan', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        // Mapper
        if ($sortBy === 'nama') $sortBy = 'nama_barang';
        if ($sortBy === 'lokasi') $sortBy = 'lokasi_ditemukan';
        
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $items = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    /**
     * Store a newly created lost/found item
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|in:hilang,ditemukan',
            'deskripsi' => 'required|string',
            'lokasi_ditemukan' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'linked_lost_id' => 'nullable|exists:lost_found_items,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('lost-found-images', 'public');
        }

        $item = LostFoundItem::create([
            'user_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'lokasi_ditemukan' => $request->lokasi_ditemukan,
            'foto' => $imagePath,
            'status' => 'pending', // Needs admin approval
            'linked_lost_id' => $request->linked_lost_id,
        ]);

        // If this is a "Found" item linked to a "Lost" item, notify the owner
        if ($request->jenis === 'ditemukan' && $request->linked_lost_id) {
            $lostItem = LostFoundItem::find($request->linked_lost_id);
            if ($lostItem) {
                $lostItem->update(['status' => 'claimed']);
                if ($lostItem->user) {
                    $lostItem->user->notify(new ItemFound(Auth::user()->name, $request->nama_barang));
                }
            }
        }

        $message = $request->jenis === 'hilang' 
            ? 'Laporan barang hilang berhasil dibuat!'
            : 'Laporan barang temuan berhasil dibuat!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $item->load('user'),
        ], 201);
    }

    /**
     * Display the specified item
     */
    public function show(LostFoundItem $lostFoundItem)
    {
        return response()->json([
            'success' => true,
            'data' => $lostFoundItem->load(['user', 'linkedLostItem']),
        ]);
    }

    /**
     * Update the specified item
     */
    public function update(Request $request, LostFoundItem $lostFoundItem)
    {
        // Check authorization
        if (Auth::id() !== $lostFoundItem->user_id && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk mengubah data ini.',
            ], 403);
        }

        $request->validate([
            'nama_barang' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'lokasi_ditemukan' => 'sometimes|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'status' => 'sometimes|in:pending,open,resolved,claimed,rejected',
        ]);

        // Only admin can update status
        if (!Auth::user()->isAdmin()) {
            $request->request->remove('status');
        }

        if ($request->hasFile('foto')) {
            // Delete old image
            if ($lostFoundItem->foto) {
                Storage::disk('public')->delete($lostFoundItem->foto);
            }
            $lostFoundItem->foto = $request->file('foto')->store('lost-found-images', 'public');
        }

        $lostFoundItem->update($request->only(['nama_barang', 'deskripsi', 'lokasi_ditemukan', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diperbarui!',
            'data' => $lostFoundItem->fresh()->load('user'),
        ]);
    }

    /**
     * Update item status (Admin only)
     */
    public function updateStatus(Request $request, LostFoundItem $lostFoundItem)
    {
        $request->validate([
            'status' => 'required|in:pending,open,resolved,claimed,rejected',
        ]);

        $lostFoundItem->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status barang berhasil diperbarui!',
            'data' => $lostFoundItem->fresh()->load('user'),
        ]);
    }

    /**
     * Confirm item return (resolve claim)
     */
    public function confirmReturn(Request $request, LostFoundItem $lostFoundItem)
    {
        // Only owner or admin can confirm
        if (Auth::id() !== $lostFoundItem->user_id && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $lostFoundItem->update(['status' => 'resolved']);

        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi pengembalian barang berhasil!',
            'data' => $lostFoundItem->fresh()->load('user'),
        ]);
    }

    /**
     * Remove the specified item
     */
    public function destroy(LostFoundItem $lostFoundItem)
    {
        // Check authorization
        if (Auth::id() !== $lostFoundItem->user_id && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk menghapus data ini.',
            ], 403);
        }

        // Delete image if exists
        if ($lostFoundItem->foto) {
            Storage::disk('public')->delete($lostFoundItem->foto);
        }

        $lostFoundItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dihapus!',
        ]);
    }

    /**
     * Get lost/found statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => LostFoundItem::count(),
            'lost_open' => LostFoundItem::where('jenis', 'hilang')->where('status', 'open')->count(),
            'lost_resolved' => LostFoundItem::where('jenis', 'hilang')->where('status', 'resolved')->count(),
            'found_open' => LostFoundItem::where('jenis', 'ditemukan')->where('status', 'open')->count(),
            'found_resolved' => LostFoundItem::where('jenis', 'ditemukan')->where('status', 'resolved')->count(),
            'pending' => LostFoundItem::where('status', 'pending')->count(),
            'claimed' => LostFoundItem::where('status', 'claimed')->count(),
            'this_week' => LostFoundItem::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => LostFoundItem::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
