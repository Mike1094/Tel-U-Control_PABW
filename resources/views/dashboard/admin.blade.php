<x-app-layout>
<<<<<<< HEAD
    <x-slot name="header">Dashboard Admin</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Laporan Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['reports_pending'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Menunggu validasi</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
=======
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Laporan</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $total_reports }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <div class="stat-card info">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Laporan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['reports_total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Semua laporan kerusakan</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
=======
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Perlu Validasi</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pending_reports }}</h3>
                </div>
                <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <div class="stat-card danger">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Barang Hilang</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['lost_items'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Belum ditemukan</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
=======
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Gate Terbuka</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $open_gates }}</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-full text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <div class="stat-card success">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Barang Ditemukan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['found_items'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Menunggu klaim</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
=======
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Barang Hilang</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $lost_items }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-full text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $usersCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Gate Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $gatesCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">CCTV Online</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $cctvCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
=======
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Analisa Laporan Harian</h3>
            <canvas id="adminChart" class="w-full h-64"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Validasi Terbaru</h3>
            <div class="space-y-4">
                @forelse($recent_reports as $report)
                <div class="flex items-start gap-3 pb-4 border-b last:border-0">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center">
                        {{ substr($report->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $report->judul }}</p>
                        <p class="text-xs text-gray-500">{{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                        <div class="mt-2 flex gap-2">
                            <button class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">Validasi</button>
                            <button class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Tolak</button>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Tidak ada laporan baru.</p>
                @endforelse
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Reports Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Status Laporan Kerusakan</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Lost Found Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Barang Hilang & Temuan</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="lostFoundChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="{{ route('admin.users.index') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('reports.index') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Validasi Laporan</span>
                </a>
                <a href="{{ route('lost-found.index') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Lost & Found</span>
                </a>
                <a href="{{ route('traffic.index') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Traffic & Gate</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Reports Table -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Menunggu Validasi</h3>
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            @if($pendingReports->isEmpty())
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="empty-state-title">Tidak ada laporan pending</p>
                    <p class="empty-state-description">Semua laporan sudah divalidasi.</p>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingReports->take(5) as $report)
                        <tr>
                            <td class="text-gray-500">{{ $report->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex items-center">
                                    <div class="avatar avatar-sm mr-2">{{ substr($report->user->name, 0, 1) }}</div>
                                    {{ $report->user->name }}
                                </div>
                            </td>
                            <td class="font-medium">{{ Str::limit($report->title, 30) }}</td>
                            <td>{{ $report->location }}</td>
                            <td>
                                <div class="flex space-x-2">
                                    <form action="{{ route('reports.update-status', $report) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="validated">
                                        <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                    </form>
                                    <form action="{{ route('reports.update-status', $report) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Pending Lost & Found Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Barang Menunggu Validasi</h3>
            <a href="{{ route('lost-found.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            @if($pendingLostFound->isEmpty())
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="empty-state-title">Tidak ada barang pending</p>
                    <p class="empty-state-description">Semua laporan barang sudah divalidasi.</p>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Nama Barang</th>
                            <th>Pelapor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingLostFound->take(5) as $item)
                        <tr>
                            <td class="text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $item->type == 'lost' ? 'badge-danger' : 'badge-info' }}">
                                    {{ $item->type == 'lost' ? 'Hilang' : 'Ditemukan' }}
                                </span>
                            </td>
                            <td class="font-medium">{{ $item->item_name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                <div class="flex space-x-2">
                                    <form action="{{ route('lost-found.update-status', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="open">
                                        <button type="submit" class="btn btn-sm btn-success">Publish</button>
                                    </form>
                                    <form action="{{ route('lost-found.update-status', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Charts Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reports Status Chart
            const reportsCtx = document.getElementById('reportsChart').getContext('2d');
            new Chart(reportsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Validated', 'In Progress', 'Completed', 'Rejected'],
                    datasets: [{
                        data: [
                            {{ $reportStats['pending'] ?? 0 }},
                            {{ $reportStats['validated'] ?? 0 }},
                            {{ $reportStats['in_progress'] ?? 0 }},
                            {{ $reportStats['completed'] ?? 0 }},
                            {{ $reportStats['rejected'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#f59e0b',
                            '#3b82f6',
                            '#8b5cf6',
                            '#10b981',
                            '#ef4444'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Lost Found Chart
            const lostFoundCtx = document.getElementById('lostFoundChart').getContext('2d');
            new Chart(lostFoundCtx, {
                type: 'bar',
                data: {
                    labels: ['Hilang', 'Ditemukan', 'Diklaim', 'Resolved'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [
                            {{ $lostFoundStats['lost_open'] ?? 0 }},
                            {{ $lostFoundStats['found_open'] ?? 0 }},
                            {{ $lostFoundStats['claimed'] ?? 0 }},
                            {{ $lostFoundStats['resolved'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#ef4444',
                            '#3b82f6',
                            '#f59e0b',
                            '#10b981'
                        ],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
=======
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('adminChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($chart_data->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: {!! json_encode(array_values($chart_data->toArray())) !!},
                    borderColor: '#ef4444', // Red-500
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { borderDash: [2, 4] } }, x: { grid: { display: false } } }
            }
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
        });
    </script>
</x-app-layout>
