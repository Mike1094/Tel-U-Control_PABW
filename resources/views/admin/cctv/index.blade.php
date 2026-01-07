<x-app-layout>
    <x-slot name="header">Kelola CCTV</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Kelola semua kamera CCTV sistem</p>
        </div>
        <a href="{{ route('admin.cctv.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah CCTV
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card text-center">
            <p class="text-xl font-bold text-gray-900">{{ $cctvs->count() }}</p>
            <p class="text-xs text-gray-500">Total CCTV</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-xl font-bold text-green-600">{{ $cctvs->where('status', 'online')->count() }}</p>
            <p class="text-xs text-gray-500">Online</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-red-500">
            <p class="text-xl font-bold text-red-600">{{ $cctvs->where('status', 'offline')->count() }}</p>
            <p class="text-xs text-gray-500">Offline</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-xl font-bold text-yellow-600">{{ $cctvs->where('status', 'maintenance')->count() }}</p>
            <p class="text-xs text-gray-500">Maintenance</p>
        </div>
    </div>

    <!-- CCTV Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Daftar CCTV</h3>
        </div>
        <div class="overflow-x-auto">
            @if($cctvs->isEmpty())
                <div class="empty-state py-12">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada CCTV</p>
                    <p class="empty-state-description">Tambahkan CCTV pertama untuk memulai.</p>
                    <a href="{{ route('admin.cctv.create') }}" class="btn btn-primary mt-4">Tambah CCTV</a>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Stream URL</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cctvs as $cctv)
                        <tr>
                            <td>
                                <div class="w-20 h-14 bg-gray-800 rounded-lg overflow-hidden flex items-center justify-center relative group">
                                    @if($cctv->thumbnail)
                                        <a href="{{ Storage::url($cctv->thumbnail) }}" target="_blank" rel="noopener noreferrer" class="block w-full h-full">
                                            <img src="{{ Storage::url($cctv->thumbnail) }}" alt="{{ $cctv->name }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </div>
                                        </a>
                                    @else
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="font-medium">{{ $cctv->name }}</td>
                            <td>{{ $cctv->location }}</td>
                            <td>
                                <span class="badge {{ $cctv->status == 'online' ? 'badge-success' : ($cctv->status == 'offline' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($cctv->status) }}
                                </span>
                            </td>
                            <td class="text-gray-500 text-sm max-w-xs truncate">{{ $cctv->stream_url ?? '-' }}</td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.cctv.edit', $cctv) }}" class="btn btn-sm btn-outline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.cctv.destroy', $cctv) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus CCTV ini?')">
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
