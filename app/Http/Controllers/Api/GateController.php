<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    /**
     * Display a listing of all gates
     */
    public function index()
    {
        $gates = Gate::with('lastUpdatedBy')->get();

        return response()->json([
            'success' => true,
            'data' => $gates,
        ]);
    }

    /**
     * Store a newly created gate
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gerbang' => 'required|string|max:255',
            'status' => 'sometimes|in:lancar,padat,macet,tutup',
        ]);

        $status = 'open';
        $trafficStatus = 'lancar';

        if ($request->status === 'tutup') {
            $status = 'closed';
            // traffic_status keeps default 'lancar' or ignored
        } else {
            $status = 'open';
            $trafficStatus = $request->status ?? 'lancar';
        }

        $gate = Gate::create([
            'nama_gerbang' => $request->nama_gerbang,
            'status' => $status,
            'traffic_status' => $trafficStatus,
            'last_updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gate berhasil ditambahkan!',
            'data' => $gate->load('lastUpdatedBy'),
        ], 201);
    }

    /**
     * Display the specified gate
     */
    public function show(Gate $gate)
    {
        return response()->json([
            'success' => true,
            'data' => $gate->load('lastUpdatedBy'),
        ]);
    }

    /**
     * Update the specified gate
     */
    public function update(Request $request, Gate $gate)
    {
        $request->validate([
            'nama_gerbang' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:lancar,padat,macet,tutup',
        ]);

        $updateData = [];
        
        if ($request->has('nama_gerbang')) {
            $updateData['nama_gerbang'] = $request->nama_gerbang;
        }
        
        if ($request->has('status')) {
            if ($request->status === 'tutup') {
                $updateData['status'] = 'closed';
            } else {
                $updateData['status'] = 'open';
                $updateData['traffic_status'] = $request->status;
            }
        }

        $updateData['last_updated_by'] = Auth::id();

        $gate->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Gate berhasil diperbarui!',
            'data' => $gate->fresh()->load('lastUpdatedBy'),
        ]);
    }

    /**
     * Update gate status only (Satpam/Admin)
     */
    public function updateStatus(Request $request, Gate $gate)
    {
        $request->validate([
            'status' => 'required|in:lancar,padat,macet,tutup',
        ]);

        $updateData = [
            'last_updated_by' => Auth::id(),
        ];

        if ($request->status === 'tutup') {
            $updateData['status'] = 'closed';
        } else {
            $updateData['status'] = 'open';
            $updateData['traffic_status'] = $request->status;
        }

        $gate->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Status gate berhasil diperbarui!',
            'data' => $gate->fresh()->load('lastUpdatedBy'),
        ]);
    }

    /**
     * Remove the specified gate
     */
    public function destroy(Gate $gate)
    {
        $gate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gate berhasil dihapus!',
        ]);
    }

    /**
     * Get gates summary
     */
    public function summary()
    {
        $gates = Gate::all();
        
        $summary = [
            'total' => $gates->count(),
            'lancar' => $gates->where('status', 'open')->where('traffic_status', 'lancar')->count(),
            'padat' => $gates->where('status', 'open')->where('traffic_status', 'padat')->count(),
            'macet' => $gates->where('status', 'open')->where('traffic_status', 'macet')->count(),
            'tutup' => $gates->where('status', 'closed')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'gates' => $gates->load('lastUpdatedBy'),
                'summary' => $summary,
            ],
        ]);
    }
}
