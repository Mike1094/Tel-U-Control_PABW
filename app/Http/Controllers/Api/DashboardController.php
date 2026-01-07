<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use App\Models\Gate;
use App\Models\LostFoundItem;
use App\Models\Report;
use App\Models\TrafficUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get comprehensive dashboard statistics for Admin
     */
    public function adminDashboard()
    {
        // Reports Statistics
        $reportsStats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'validated' => Report::where('status', 'validated')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'completed' => Report::where('status', 'completed')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        // Lost & Found Statistics
        $lostFoundStats = [
            'total' => LostFoundItem::count(),
            'lost_open' => LostFoundItem::where('type', 'lost')->where('status', 'open')->count(),
            'found_open' => LostFoundItem::where('type', 'found')->where('status', 'open')->count(),
            'pending' => LostFoundItem::where('status', 'pending')->count(),
            'resolved' => LostFoundItem::where('status', 'resolved')->count(),
            'claimed' => LostFoundItem::where('status', 'claimed')->count(),
        ];

        // Users Statistics
        $usersStats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'satpam' => User::where('role', 'satpam')->count(),
            'civitas' => User::where('role', 'civitas')->count(),
            'warga' => User::where('role', 'warga')->count(),
        ];

        // Gates Statistics
        $gatesStats = [
            'total' => Gate::count(),
            'lancar' => Gate::where('status', 'lancar')->count(),
            'padat' => Gate::where('status', 'padat')->count(),
            'macet' => Gate::where('status', 'macet')->count(),
            'tutup' => Gate::where('status', 'tutup')->count(),
        ];

        // Traffic Statistics (last 24 hours)
        $trafficStats = [
            'total_24h' => TrafficUpdate::where('created_at', '>=', now()->subHours(24))->count(),
            'lancar' => TrafficUpdate::where('status', 'lancar')->where('created_at', '>=', now()->subHours(24))->count(),
            'padat' => TrafficUpdate::where('status', 'padat')->where('created_at', '>=', now()->subHours(24))->count(),
            'macet' => TrafficUpdate::where('status', 'macet')->where('created_at', '>=', now()->subHours(24))->count(),
        ];

        // CCTV Statistics
        $cctvStats = [
            'total' => Cctv::count(),
            'online' => Cctv::where('status', 'online')->count(),
            'offline' => Cctv::where('status', 'offline')->count(),
            'maintenance' => Cctv::where('status', 'maintenance')->count(),
        ];

        // Recent activities
        $recentReports = Report::with('user')->latest()->take(5)->get();
        $recentLostFound = LostFoundItem::with('user')->latest()->take(5)->get();
        $pendingReports = Report::with('user')->where('status', 'pending')->latest()->get();
        $pendingLostFound = LostFoundItem::with('user')->where('status', 'pending')->latest()->get();

        // Monthly trends (last 6 months)
        $monthlyReports = Report::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyLostFound = LostFoundItem::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('type'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month', 'type')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'reports' => $reportsStats,
                'lost_found' => $lostFoundStats,
                'users' => $usersStats,
                'gates' => $gatesStats,
                'traffic' => $trafficStats,
                'cctv' => $cctvStats,
                'recent_reports' => $recentReports,
                'recent_lost_found' => $recentLostFound,
                'pending_reports' => $pendingReports,
                'pending_lost_found' => $pendingLostFound,
                'trends' => [
                    'reports' => $monthlyReports,
                    'lost_found' => $monthlyLostFound,
                ],
            ],
        ]);
    }

    /**
     * Get dashboard for Satpam
     */
    public function satpamDashboard()
    {
        $gates = Gate::with('lastUpdatedBy')->get();
        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(10)->get();
        $foundItems = LostFoundItem::with('user')
            ->where('type', 'found')
            ->whereIn('status', ['open', 'pending'])
            ->latest()
            ->get();

        $gatesStats = [
            'total' => $gates->count(),
            'lancar' => $gates->where('status', 'lancar')->count(),
            'padat' => $gates->where('status', 'padat')->count(),
            'macet' => $gates->where('status', 'macet')->count(),
            'tutup' => $gates->where('status', 'tutup')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'gates' => $gates,
                'gates_stats' => $gatesStats,
                'traffic_updates' => $trafficUpdates,
                'found_items' => $foundItems,
            ],
        ]);
    }

    /**
     * Get dashboard for Civitas (Dosen/Mahasiswa)
     */
    public function civitasDashboard()
    {
        $userId = Auth::id();

        $myReports = Report::where('user_id', $userId)->latest()->get();
        $myLostFound = LostFoundItem::where('user_id', $userId)->latest()->get();
        
        $gates = Gate::with('lastUpdatedBy')->get();
        $latestTraffic = TrafficUpdate::with('user')->latest()->take(5)->get();
        $cctvs = Cctv::where('status', 'online')->get();

        // Stats
        $myStats = [
            'reports_total' => $myReports->count(),
            'reports_pending' => $myReports->where('status', 'pending')->count(),
            'reports_completed' => $myReports->where('status', 'completed')->count(),
            'lost_items' => $myLostFound->where('type', 'lost')->count(),
            'found_items' => $myLostFound->where('type', 'found')->count(),
        ];

        // Public lost items that others reported
        $publicLostItems = LostFoundItem::with('user')
            ->where('type', 'lost')
            ->where('status', 'open')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'my_reports' => $myReports,
                'my_lost_found' => $myLostFound,
                'my_stats' => $myStats,
                'gates' => $gates,
                'latest_traffic' => $latestTraffic,
                'cctvs' => $cctvs,
                'public_lost_items' => $publicLostItems,
            ],
        ]);
    }

    /**
     * Get dashboard for Warga
     */
    public function wargaDashboard()
    {
        $cctvs = Cctv::where('status', 'online')->get();
        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(10)->get();
        $gates = Gate::with('lastUpdatedBy')->get();

        // Public reports summary (anonymous)
        $publicReports = Report::whereIn('status', ['validated', 'in_progress'])
            ->latest()
            ->take(10)
            ->get(['id', 'title', 'location', 'status', 'created_at']);

        return response()->json([
            'success' => true,
            'data' => [
                'cctvs' => $cctvs,
                'traffic_updates' => $trafficUpdates,
                'gates' => $gates,
                'public_reports' => $publicReports,
            ],
        ]);
    }

    /**
     * Get dashboard based on authenticated user role
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'satpam':
                return $this->satpamDashboard();
            case 'warga':
                return $this->wargaDashboard();
            default:
                return $this->civitasDashboard();
        }
    }
}
