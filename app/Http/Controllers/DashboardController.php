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
<<<<<<< HEAD
        // Main Stats
        $stats = [
            'reports_pending' => Report::where('status', 'pending')->count(),
            'reports_total' => Report::count(),
            'lost_items' => LostFoundItem::where('type', 'lost')->where('status', 'open')->count(),
            'found_items' => LostFoundItem::where('type', 'found')->where('status', 'open')->count(),
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
            'lost_open' => LostFoundItem::where('type', 'lost')->where('status', 'open')->count(),
            'found_open' => LostFoundItem::where('type', 'found')->where('status', 'open')->count(),
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
=======
        // 1. Ambil data count untuk statistik
        $total_reports = Report::count();
        $pending_reports = Report::where('status', 'pending')->count();
        $open_gates = Gate::where('status', 'open')->count();

        // 2. Data tambahan untuk Admin (Lost & Found)
        $lost_items = LostFoundItem::where('jenis', 'hilang')->where('status', 'open')->count();
        $found_items = LostFoundItem::where('jenis', 'ditemukan')->where('status', 'open')->count();

        // 3. Data Tabel Validasi
        $recent_reports = Report::where('status', 'pending')->with('user')->latest()->take(5)->get();

        // 4. Data Grafik Analisa Harian
        $chart_data = Report::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        // RETURN: Menggunakan compact() dengan nama variabel yang sesuai di View
        return view('dashboard.admin', compact(
            'total_reports',
            'pending_reports',
            'open_gates',
            'recent_reports',
            'chart_data',
            'lost_items',
            'found_items'
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        ));
    }

    private function satpamDashboard()
    {
<<<<<<< HEAD
        $gates = Gate::with('lastUpdatedBy')->get();
        $trafficUpdates = TrafficUpdate::with('user')->latest()->take(10)->get();
        
        // Found items to review
        $foundItems = LostFoundItem::with('user')
            ->where('type', 'found')
            ->whereIn('status', ['open', 'pending'])
            ->latest()
            ->take(5)
            ->get();

        // Gate stats
        $gateStats = [
            'total' => $gates->count(),
            'lancar' => $gates->where('status', 'lancar')->count(),
            'padat' => $gates->where('status', 'padat')->count(),
            'macet' => $gates->where('status', 'macet')->count(),
            'tutup' => $gates->where('status', 'tutup')->count(),
        ];

        return view('dashboard.satpam', compact('gates', 'trafficUpdates', 'foundItems', 'gateStats'));
=======
        $gates = Gate::all();
        $trafficUpdates = TrafficUpdate::latest()->take(5)->get();
        return view('dashboard.satpam', compact('gates', 'trafficUpdates'));
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }

    private function civitasDashboard()
    {
<<<<<<< HEAD
        $userId = Auth::id();

        $myReports = Report::where('user_id', $userId)->latest()->get();
        $myLostFound = LostFoundItem::where('user_id', $userId)->latest()->get();

        // Stats
        $myStats = [
            'reports_total' => $myReports->count(),
            'reports_pending' => $myReports->where('status', 'pending')->count(),
            'reports_completed' => $myReports->where('status', 'completed')->count(),
            'lost_items' => $myLostFound->where('type', 'lost')->count(),
            'found_items' => $myLostFound->where('type', 'found')->count(),
        ];

        // Gate & Traffic info
        $gates = Gate::with('lastUpdatedBy')->get();
        $latestTraffic = TrafficUpdate::with('user')->latest()->take(5)->get();

        // Public lost items
        $publicLostItems = LostFoundItem::with('user')
            ->where('type', 'lost')
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
=======
        $myReports = Report::where('user_id', Auth::id())->latest()->take(5)->get();
        $myLostFound = LostFoundItem::where('user_id', Auth::id())->latest()->take(5)->get();
        $cctvs = $this->getMockCctvs();
        $gates = Gate::all();

        return view('dashboard.civitas', compact('myReports', 'myLostFound', 'cctvs', 'gates'));
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }

    private function wargaDashboard()
    {
<<<<<<< HEAD
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
=======
        $cctvs = $this->getMockCctvs();
        $trafficUpdates = TrafficUpdate::latest()->take(5)->get();
        $gates = Gate::all();

        return view('dashboard.warga', compact('cctvs', 'trafficUpdates', 'gates'));
    }

    private function getMockCctvs()
    {
        return [
            ['name' => 'Gerbang Depan', 'status' => 'Online', 'image' => 'https://images.unsplash.com/photo-1565514020176-1c25039df8eb?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Parkiran Gd. A', 'status' => 'Online', 'image' => 'https://images.unsplash.com/photo-1590674899505-1c5c4127193c?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Kantin Asrama', 'status' => 'Maintenance', 'image' => 'https://images.unsplash.com/photo-1555447425-69bc336b7325?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Perpustakaan', 'status' => 'Online', 'image' => 'https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=400&q=80'],
        ];
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }
}
