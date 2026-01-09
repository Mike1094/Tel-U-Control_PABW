<?php

namespace App\Http\Controllers;

use App\Models\LostFoundItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ItemFound;

class LostFoundController extends Controller
{
    public function index()
    {
        $items = LostFoundItem::with('user')->whereIn('status', ['open', 'pending', 'claimed'])->latest()->get();
        return view('lost-found.index', compact('items'));
    }

    public function create(Request $request)
    {
        // Get lost items for linking (when reporting found item)
        $lostItems = LostFoundItem::with('user')->where('jenis', 'hilang')->where('status', 'open')->get();

        return view('lost-found.create', [
            'lostItems' => $lostItems,
            'jenis' => $request->query('jenis', 'hilang'),
            'linked_lost_id' => $request->query('linked_lost_id')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|in:hilang,ditemukan',
            'deskripsi' => 'required|string',
            'lokasi_ditemukan' => 'required|string',
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
            'status' => 'open',
            'linked_lost_id' => $request->linked_lost_id,
        ]);

        // Notify owner if found item is linked to a lost item
        if ($request->jenis === 'ditemukan' && $request->linked_lost_id) {
            $lostItem = LostFoundItem::find($request->linked_lost_id);
            if ($lostItem) {
                $lostItem->update(['status' => 'claimed']);
                // Optionally send notification
                // if ($lostItem->user) {
                //     $lostItem->user->notify(new ItemFound(Auth::user()->name, $request->nama_barang));
                // }
            }
        }

        return redirect()->route('lost-found.index')->with('success', 'Barang berhasil dilaporkan!');
    }

    public function update(Request $request, LostFoundItem $lostFoundItem)
    {
        // Allow Admin or Owner to mark as resolved
        if (Auth::user()->role !== 'admin' && Auth::id() !== $lostFoundItem->user_id) {
            abort(403);
        }

        $lostFoundItem->update(['status' => 'resolved']);
        return back()->with('success', 'Status barang diperbarui menjadi selesai!');
    }

    public function updateStatus(Request $request, LostFoundItem $lostFoundItem)
    {
        // Only Admin or Owner can update status
        if (Auth::user()->role !== 'admin' && Auth::id() !== $lostFoundItem->user_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:open,claimed,resolved'
        ]);

        $lostFoundItem->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status laporan barang diperbarui!',
                'status' => $lostFoundItem->status,
            ]);
        }

        return back()->with('success', 'Status laporan barang diperbarui!');
    }

    public function destroy(LostFoundItem $lostFoundItem)
    {
        // Check authorization: owner or admin
        if (Auth::id() !== $lostFoundItem->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($lostFoundItem->foto) {
            Storage::disk('public')->delete($lostFoundItem->foto);
        }

        $lostFoundItem->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan barang berhasil dihapus.'
            ]);
        }

        return back()->with('success', 'Laporan barang berhasil dihapus.');
    }
}
