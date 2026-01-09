<x-app-layout>
    <x-slot name="header">Kelola Gate</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Kelola semua pintu gerbang kampus</p>
        </div>
        <a href="{{ route('admin.gates.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Gate
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="stat-card text-center">
            <p class="text-xl font-bold text-gray-900">{{ $gates->count() }}</p>
            <p class="text-xs text-gray-500">Total Gate</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-xl font-bold text-green-600">{{ $gates->where('traffic_status', 'lancar')->count() }}</p>
            <p class="text-xs text-gray-500">Lancar</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-xl font-bold text-yellow-600">{{ $gates->where('traffic_status', 'padat')->count() }}</p>
            <p class="text-xs text-gray-500">Padat</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-red-500">
            <p class="text-xl font-bold text-red-600">{{ $gates->where('traffic_status', 'macet')->count() }}</p>
            <p class="text-xs text-gray-500">Macet</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-gray-500">
            <p class="text-xl font-bold text-gray-600">{{ $gates->where('status', 'closed')->count() }}</p>
            <p class="text-xs text-gray-500">Tutup</p>
        </div>
    </div>

    <!-- Gates Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Gate</h3>
        </div>
        <div class="overflow-x-auto">
            @if($gates->isEmpty())
                <div class="empty-state py-12">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4"/>
                    </svg>
                    <p class="empty-state-title">Belum ada Gate</p>
                    <p class="empty-state-description">Tambahkan gate pertama untuk memulai.</p>
                    <a href="{{ route('admin.gates.create') }}" class="btn btn-primary mt-4">Tambah Gate</a>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Gate</th>
                            <th>Status Gate</th>
                            <th>Status Lalu Lintas</th>
                            <th>CCTV URL</th>
                            <th>Terakhir Diperbarui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gates as $gate)
                        <tr>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full {{ $gate->status == 'open' ? ($gate->traffic_status == 'lancar' ? 'bg-green-500' : ($gate->traffic_status == 'padat' ? 'bg-yellow-500' : 'bg-red-500')) : 'bg-gray-500' }}"></div>
                                    <span class="font-medium">{{ $gate->nama_gerbang }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $gate->status == 'open' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $gate->status == 'open' ? 'Buka' : 'Tutup' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge traffic-{{ $gate->traffic_status ?? 'lancar' }}">
                                    {{ ucfirst($gate->traffic_status ?? 'lancar') }}
                                </span>
                            </td>
                            <td class="text-gray-500 text-sm max-w-xs truncate">{{ $gate->cctv_url ?? '-' }}</td>
                            <td class="text-gray-500">{{ $gate->updated_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.gates.edit', $gate) }}" class="btn btn-sm btn-outline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.gates.destroy', $gate) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus gate ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline text-red-600 hover:bg-red-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
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
</x-app-layout>
