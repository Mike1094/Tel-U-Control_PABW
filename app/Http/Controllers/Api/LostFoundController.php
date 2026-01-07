<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LostFoundItem;
<<<<<<< HEAD
use App\Models\User;
use App\Notifications\ItemFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
=======
use Illuminate\Http\Request;
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
use Illuminate\Support\Facades\Storage;

class LostFoundController extends Controller
{
<<<<<<< HEAD
    /**
     * Display a listing of lost/found items
     */
=======
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    public function index(Request $request)
    {
        $query = LostFoundItem::with('user');

<<<<<<< HEAD
        // Filter by type (lost/found)
        if ($request->has('type')) {
            $query->where('type', $request->type);
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
                $q->where('item_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
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
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:lost,found',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'linked_lost_id' => 'nullable|exists:lost_found_items,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lost-found-images', 'public');
        }

        $item = LostFoundItem::create([
            'user_id' => Auth::id(),
            'item_name' => $request->item_name,
            'type' => $request->type,
            'description' => $request->description,
            'location' => $request->location,
            'image' => $imagePath,
            'status' => 'pending', // Needs admin approval
            'linked_lost_id' => $request->linked_lost_id,
        ]);

        // If this is a "Found" item linked to a "Lost" item, notify the owner
        if ($request->type === 'found' && $request->linked_lost_id) {
            $lostItem = LostFoundItem::find($request->linked_lost_id);
            if ($lostItem) {
                $lostItem->update(['status' => 'claimed']);
                if ($lostItem->user) {
                    $lostItem->user->notify(new ItemFound(Auth::user()->name, $request->item_name));
                }
            }
        }

        $message = $request->type === 'lost' 
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
            'item_name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'sometimes|in:pending,open,resolved,claimed,rejected',
        ]);

        // Only admin can update status
        if (!Auth::user()->isAdmin()) {
            $request->request->remove('status');
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($lostFoundItem->image) {
                Storage::disk('public')->delete($lostFoundItem->image);
            }
            $lostFoundItem->image = $request->file('image')->store('lost-found-images', 'public');
        }

        $lostFoundItem->update($request->only(['item_name', 'description', 'location', 'status']));

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
        if ($lostFoundItem->image) {
            Storage::disk('public')->delete($lostFoundItem->image);
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
            'lost_open' => LostFoundItem::where('type', 'lost')->where('status', 'open')->count(),
            'lost_resolved' => LostFoundItem::where('type', 'lost')->where('status', 'resolved')->count(),
            'found_open' => LostFoundItem::where('type', 'found')->where('status', 'open')->count(),
            'found_resolved' => LostFoundItem::where('type', 'found')->where('status', 'resolved')->count(),
            'pending' => LostFoundItem::where('status', 'pending')->count(),
            'claimed' => LostFoundItem::where('status', 'claimed')->count(),
            'this_week' => LostFoundItem::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => LostFoundItem::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
=======
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi_ditemukan' => 'nullable|string',
            'jenis' => 'required|in:hilang,ditemukan',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('lost-found', 'public');
        }

        $item = LostFoundItem::create([
            'user_id' => $request->user()->id,
            'nama_barang' => $validated['nama_barang'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi_ditemukan' => $validated['lokasi_ditemukan'],
            'jenis' => $validated['jenis'],
            'status' => 'open',
            'foto' => $path,
        ]);

        return response()->json([
            'message' => 'Laporan barang berhasil dibuat',
            'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = LostFoundItem::with('user')->find($id);

        if (!$item) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = LostFoundItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $this->authorize('update', $item);

        $validated = $request->validate([
            'nama_barang' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'lokasi_ditemukan' => 'nullable|string',
            'status' => 'sometimes|in:open,claimed,resolved',
        ]);

        $item->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = LostFoundItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $this->authorize('delete', $item);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }
}
