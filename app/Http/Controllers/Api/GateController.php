<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gate;
<<<<<<< HEAD
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
            'name' => 'required|string|max:255',
            'status' => 'sometimes|in:lancar,padat,macet,tutup',
        ]);

        $gate = Gate::create([
            'name' => $request->name,
            'status' => $request->status ?? 'lancar',
            'is_open' => $request->status !== 'tutup',
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
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:lancar,padat,macet,tutup',
        ]);

        $updateData = [];
        
        if ($request->has('name')) {
            $updateData['name'] = $request->name;
        }
        
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
            $updateData['is_open'] = $request->status !== 'tutup';
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

        $gate->update([
            'status' => $request->status,
            'is_open' => $request->status !== 'tutup',
            'last_updated_by' => Auth::id(),
        ]);

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
            'lancar' => $gates->where('status', 'lancar')->count(),
            'padat' => $gates->where('status', 'padat')->count(),
            'macet' => $gates->where('status', 'macet')->count(),
            'tutup' => $gates->where('status', 'tutup')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'gates' => $gates->load('lastUpdatedBy'),
                'summary' => $summary,
            ],
=======
use App\Models\TrafficUpdate;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function index()
    {
        $gates = Gate::all();
        return response()->json($gates);
    }

    public function show($id)
    {
        $gate = Gate::find($id);
        if (!$gate) {
            return response()->json(['message' => 'Gate tidak ditemukan'], 404);
        }
        return response()->json($gate);
    }

    public function update(Request $request, $id)
    {
        $gate = Gate::find($id);

        if (!$gate) {
            return response()->json(['message' => 'Gate tidak ditemukan'], 404);
        }

        $user = $request->user();
        if (!in_array($user->role, ['satpam', 'admin'])) {
            return response()->json(['message' => 'Unauthorized. Hanya Satpam/Admin.'], 403);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:open,closed',
            'traffic_status' => 'sometimes|in:lancar,padat,macet',
        ]);

        $gate->update($validated);

        if ($request->has('traffic_status')) {
            TrafficUpdate::create([
                'gate_id' => $gate->id,
                'user_id' => $user->id,
                'status' => $request->traffic_status,
                'description' => 'Update status via API'
            ]);
        }

        return response()->json([
            'message' => 'Status Gate berhasil diperbarui',
            'data' => $gate
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        ]);
    }
}
