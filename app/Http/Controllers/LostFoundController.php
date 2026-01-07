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
<<<<<<< HEAD
        $items = LostFoundItem::with('user')->whereIn('status', ['open', 'pending', 'claimed'])->latest()->get();
=======
        // Semua role boleh melihat barang hilang/ditemukan yang statusnya Open/Claimed
        $items = LostFoundItem::whereIn('status', ['open', 'claimed', 'resolved'])->with('user')->latest()->get();
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        return view('lost-found.index', compact('items'));
    }

    public function create(Request $request)
    {
        // Sesuaikan nama kolom jenis/type sesuai migration (jenis)
        $lostItems = LostFoundItem::where('jenis', 'hilang')->where('status', 'open')->get();

        return view('lost-found.create', [
            'lostItems' => $lostItems,
            'jenis' => $request->query('jenis'), // hilangkan type, gunakan jenis
            'linked_lost_id' => $request->query('linked_lost_id')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|in:hilang,ditemukan', // Sesuaikan migration
            'deskripsi' => 'required|string',
            'lokasi_ditemukan' => 'nullable|string', // Lokasi
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
            'lokasi_ditemukan' => $request->lokasi_ditemukan, // field lokasi
            'foto' => $imagePath,
            'status' => 'open', // Default open
            'linked_lost_id' => $request->linked_lost_id,
        ]);

        // Notifikasi jika barang ditemukan cocok dengan laporan hilang
        if ($request->jenis === 'ditemukan' && $request->linked_lost_id) {
            $lostItem = LostFoundItem::find($request->linked_lost_id);
            if ($lostItem) {
                $lostItem->update(['status' => 'claimed']);
                // Kirim notifikasi (pastikan User model punya Trait Notifiable)
                if ($lostItem->user) {
                   // $lostItem->user->notify(new ItemFound(Auth::user()->name, $request->nama_barang));
                }
            }
        }

        return redirect()->route('lost-found.index')->with('success', 'Barang berhasil dilaporkan!');
    }

    public function updateStatus(Request $request, LostFoundItem $lostFoundItem)
    {
        // Hanya Admin atau Pemilik yang boleh update status selesai
        if (Auth::user()->role !== 'admin' && Auth::id() !== $lostFoundItem->user_id) {
            abort(403);
        }

        $request->validate([
<<<<<<< HEAD
            'status' => 'required|in:pending,open,resolved,claimed,rejected'
=======
            'status' => 'required|in:open,claimed,resolved'
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        ]);

        $lostFoundItem->update(['status' => $request->status]);

<<<<<<< HEAD
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status laporan barang diperbarui!',
                'status' => $lostFoundItem->status,
            ]);
        }

        return back()->with('success', 'Status laporan barang diperbarui!');
=======
        return back()->with('success', 'Status barang diperbarui!');
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }

    public function destroy(LostFoundItem $lostFoundItem)
    {
<<<<<<< HEAD
        // Cek otorisasi: owner atau admin
=======
        $lostFoundItem = LostFoundItem::findOrFail($id);

>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        if (Auth::id() !== $lostFoundItem->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($lostFoundItem->foto) { // sesuaikan field foto
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
