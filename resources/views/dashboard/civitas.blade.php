<x-app-layout>
    <x-slot name="header">Dashboard Civitas Akademika</x-slot>

    <!-- My Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="stat-card primary text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $myStats['reports_total'] }}</p>
            <p class="text-sm text-gray-500">Laporan Saya</p>
        </div>
        <div class="stat-card warning text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ $myStats['reports_pending'] }}</p>
            <p class="text-sm text-gray-500">Pending</p>
        </div>
        <div class="stat-card success text-center">
            <p class="text-2xl font-bold text-green-600">{{ $myStats['reports_completed'] }}</p>
            <p class="text-sm text-gray-500">Selesai</p>
        </div>
        <div class="stat-card danger text-center">
            <p class="text-2xl font-bold text-red-600">{{ $myStats['lost_items'] }}</p>
            <p class="text-sm text-gray-500">Barang Hilang</p>
        </div>
        <div class="stat-card info text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $myStats['found_items'] }}</p>
            <p class="text-sm text-gray-500">Barang Ditemukan</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="{{ route('reports.create') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Laporkan Kerusakan</span>
                </a>
                <a href="{{ route('lost-found.create') }}?type=lost" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Lapor Barang Hilang</span>
                </a>
                <a href="{{ route('lost-found.create') }}?type=found" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Lapor Barang Temuan</span>
                </a>
                <a href="{{ route('traffic.index') }}" class="quick-action-card">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Info Lalu Lintas</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- My Recent Reports -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Laporan Saya</h3>
                <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($myReports->isEmpty())
                    <div class="empty-state py-8">
                        <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 mt-3">Belum ada laporan</p>
                        <a href="{{ route('reports.create') }}" class="btn btn-primary btn-sm mt-4">Buat Laporan</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($myReports->take(5) as $report)
                        <div class="flex items-start justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->title }}</p>
                                <p class="text-sm text-gray-500">{{ $report->location }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="badge status-{{ $report->status }}">
                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- My Lost/Found Items -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Barang Saya</h3>
                <a href="{{ route('lost-found.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($myLostFound->isEmpty())
                    <div class="empty-state py-8">
                        <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-gray-500 mt-3">Belum ada laporan barang</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($myLostFound->take(5) as $item)
                        <div class="flex items-start justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->item_name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->location }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex flex-col items-end space-y-1">
                                <span class="badge {{ $item->type == 'lost' ? 'badge-danger' : 'badge-info' }}">
                                    {{ $item->type == 'lost' ? 'Hilang' : 'Ditemukan' }}
                                </span>
                                <span class="badge badge-secondary text-xs">{{ ucfirst($item->status) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Gate Status -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Status Gate</h3>
            <a href="{{ route('traffic.index') }}" class="btn btn-sm btn-outline-primary">Detail</a>
        </div>
        <div class="card-body">
            @if($gates->isEmpty())
                <p class="text-gray-500 text-center py-4">Tidak ada data gate</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($gates as $gate)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="gate-indicator {{ $gate->status ?? 'lancar' }}"></div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $gate->name }}</p>
                            <span class="badge traffic-{{ $gate->status ?? 'lancar' }} text-xs">
                                {{ ucfirst($gate->status ?? 'lancar') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Public Lost Items (Others) -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Barang Hilang - Mungkin Milik Anda?</h3>
            <a href="{{ route('lost-found.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($publicLostItems->isEmpty())
                <div class="empty-state py-8">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 mt-3">Tidak ada laporan barang hilang saat ini</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($publicLostItems as $item)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-red-300 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $item->item_name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->location }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('lost-found.create') }}?type=found&linked_lost_id={{ $item->id }}" class="btn btn-sm btn-success w-full">
                                Saya Menemukan Ini
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
