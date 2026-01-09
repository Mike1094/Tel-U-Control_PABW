<x-app-layout>
    <x-slot name="header">Dashboard Warga Sekitar</x-slot>

    <!-- Gate Status Overview -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Status Gate Kampus</h3>
        </div>
        <div class="card-body">
            @if($gates->isEmpty())
                <p class="text-gray-500 text-center py-4">Tidak ada data gate</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($gates as $gate)
                    <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                        <div class="gate-indicator {{ $gate->status ?? 'lancar' }}"></div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $gate->name }}</p>
                            <span class="badge traffic-{{ $gate->status ?? 'lancar' }}">
                                {{ ucfirst($gate->status ?? 'lancar') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- CCTV -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">CCTV Sekitar</h3>
                <span class="badge badge-success">{{ $cctvs->count() }} Online</span>
            </div>
            <div class="card-body">
                @if($cctvs->isEmpty())
                    <div class="empty-state py-8">
                        <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 mt-3">Tidak ada CCTV tersedia</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($cctvs as $cctv)
                        <div class="relative group cursor-pointer">
                            <div class="aspect-video bg-gray-800 rounded-lg overflow-hidden flex items-center justify-center">
                                @if(isset($cctv->thumbnail) && $cctv->thumbnail)
                                    <img src="{{ Storage::url($cctv->thumbnail) }}" alt="{{ $cctv->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs mt-1">Live Feed</p>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 text-white">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full mr-1 animate-pulse"></span>
                                        Live
                                    </span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-900">{{ $cctv->name }}</p>
                            <p class="text-xs text-gray-500">{{ $cctv->location }}</p>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Traffic Updates -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Update Lalu Lintas</h3>
            </div>
            <div class="card-body">
                @if($trafficUpdates->isEmpty())
                    <div class="empty-state py-8">
                        <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <p class="text-gray-500 mt-3">Tidak ada update lalu lintas</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($trafficUpdates as $update)
                        <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    {{ $update->status == 'lancar' ? 'bg-green-100' : ($update->status == 'padat' ? 'bg-yellow-100' : 'bg-red-100') }}">
                                    <svg class="w-5 h-5 {{ $update->status == 'lancar' ? 'text-green-600' : ($update->status == 'padat' ? 'text-yellow-600' : 'text-red-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-900">{{ $update->location }}</p>
                                    <span class="badge traffic-{{ $update->status }}">{{ ucfirst($update->status) }}</span>
                                </div>
                                @if($update->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $update->description }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $update->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Public Reports -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Fasilitas</h3>
            <span class="text-sm text-gray-500">Informasi kerusakan fasilitas kampus</span>
        </div>
        <div class="overflow-x-auto">
            @if($publicReports->isEmpty())
                <div class="empty-state py-8">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 mt-3">Tidak ada laporan fasilitas saat ini</p>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publicReports as $report)
                        <tr>
                            <td class="text-gray-500">{{ $report->created_at->format('d M Y') }}</td>
                            <td class="font-medium">{{ $report->title }}</td>
                            <td>{{ $report->location }}</td>
                            <td>
                                <span class="badge status-{{ $report->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Information Note -->
    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-medium text-blue-800">Informasi untuk Warga Sekitar</p>
                <p class="text-sm text-blue-700 mt-1">
                    Anda dapat melihat status gate, CCTV, dan update lalu lintas kampus. 
                    Untuk melaporkan kerusakan fasilitas atau barang hilang, silakan hubungi petugas kampus.
                </p>
            </div>
        </div>
    </div>

    {{-- <script>
        setInterval(() => {
            const now = new Date();
            const timeString = now.toLocaleDateString('id-ID') + ' ' + now.toLocaleTimeString('id-ID');
            document.querySelectorAll('.cctv-time').forEach(el => el.innerText = timeString);
        }, 1000);
    </script> --}}
</x-app-layout>
