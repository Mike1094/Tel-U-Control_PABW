<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
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

    private function adminDashboard()
    {
        // Main Stats
        $stats = [
            'reports_pending' => Report::where('status', 'pending')->count(),
            'reports_total' => Report::count(),
            'lost_items' => LostFoundItem::where('jenis', 'hilang')->where('status', 'open')->count(),
            'found_items' => LostFoundItem::where('jenis', 'ditemukan')->where('status', 'open')->count(),
        ];

        // Report Stats by Status
        $reportStats = [
            'pending' => Report::where('status', 'pending')->count(),
            'validated' => Report::where('status', 'validated')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'completed' => Report::where('status', 'completed')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        // Lost Found Stats
        $lostFoundStats = [
            'lost_open' => LostFoundItem::where('jenis', 'hilang')->where('status', 'open')->count(),
            'found_open' => LostFoundItem::where('jenis', 'ditemukan')->where('status', 'open')->count(),
            'claimed' => LostFoundItem::where('status', 'claimed')->count(),
            'resolved' => LostFoundItem::where('status', 'resolved')->count(),
        ];

        // Counts
        $usersCount = User::count();
        $gatesCount = Gate::count();
        $cctvCount = Cctv::where('status', 'online')->count();

        // Pending items for validation
        $pendingReports = Report::where('status', 'pending')->with('user')->latest()->get();
        $pendingLostFound = LostFoundItem::where('status', 'pending')->with('user')->latest()->get();

        return view('dashboard.admin', compact(
            'stats',
            'reportStats',
            'lostFoundStats',
            'usersCount',
            'gatesCount',
            'cctvCount',
            'pendingReports',
            'pendingLostFound'
        ));
    }

    private function satpamDashboard()
    {
        $gates = Gate::with('lastUpdatedBy')->get();
        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(10)->get();
        
        // Found items to review
        $foundItems = LostFoundItem::with('user')
            ->where('jenis', 'ditemukan')
            ->whereIn('status', ['open', 'pending'])
            ->latest()
            ->take(5)
            ->get();

        // Gate stats
        $gateStats = [
            'total' => $gates->count(),
            'lancar' => $gates->where('status', 'open')->where('traffic_status', 'lancar')->count(),
            'padat' => $gates->where('status', 'open')->where('traffic_status', 'padat')->count(),
            'macet' => $gates->where('status', 'open')->where('traffic_status', 'macet')->count(),
            'tutup' => $gates->where('status', 'closed')->count(),
        ];

        return view('dashboard.satpam', compact('gates', 'trafficUpdates', 'foundItems', 'gateStats'));
    }

    private function civitasDashboard()
    {
        $userId = Auth::id();

        $myReports = Report::where('user_id', $userId)->latest()->get();
        $myLostFound = LostFoundItem::where('user_id', $userId)->latest()->get();

        // Stats
        $myStats = [
            'reports_total' => $myReports->count(),
            'reports_pending' => $myReports->where('status', 'pending')->count(),
            'reports_completed' => $myReports->where('status', 'completed')->count(),
            'lost_items' => $myLostFound->where('jenis', 'hilang')->count(),
            'found_items' => $myLostFound->where('jenis', 'ditemukan')->count(),
        ];

        // Gate & Traffic info
        $gates = Gate::with('lastUpdatedBy')->get();
        $latestTraffic = TrafficUpdate::with('user')->latest()->take(5)->get();

        // Public lost items
        $publicLostItems = LostFoundItem::with('user')
            ->where('jenis', 'hilang')
            ->where('status', 'open')
            ->where('user_id', '!=', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.civitas', compact(
            'myReports',
            'myLostFound',
            'myStats',
            'gates',
            'latestTraffic',
            'publicLostItems'
        ));
    }

    private function wargaDashboard()
    {
        // CCTVs
        $cctvs = Cctv::where('status', 'online')->get();

        // If CCTV table is empty, use mock data
        if ($cctvs->isEmpty()) {
            $cctvs = collect([
                (object)['id' => 1, 'name' => 'Gerbang Utama', 'location' => 'Pintu Masuk', 'status' => 'online', 'thumbnail' => null],
                (object)['id' => 2, 'name' => 'Parkiran A', 'location' => 'Area Parkir', 'status' => 'online', 'thumbnail' => null],
                (object)['id' => 3, 'name' => 'Gedung Rektorat', 'location' => 'Lobby', 'status' => 'online', 'thumbnail' => null],
                (object)['id' => 4, 'name' => 'Taman Kampus', 'location' => 'Area Terbuka', 'status' => 'online', 'thumbnail' => null],
            ]);
        }

        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(5)->get();
        $gates = Gate::with('lastUpdatedBy')->get();

        // Public reports summary
        $publicReports = Report::whereIn('status', ['validated', 'in_progress', 'completed'])
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'location', 'status', 'created_at']);

        return view('dashboard.warga', compact('cctvs', 'trafficUpdates', 'gates', 'publicReports'));
    }
}
