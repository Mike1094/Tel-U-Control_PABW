
<x-app-layout>
    <x-slot name="header">Dashboard Satpam</x-slot>

    <!-- Gate Status Overview -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="stat-card text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $gateStats['total'] }}</p>
            <p class="text-sm text-gray-500">Total Gate</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-2xl font-bold text-green-600">{{ $gateStats['lancar'] }}</p>
            <p class="text-sm text-gray-500">Lancar</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-2xl font-bold text-yellow-600">{{ $gateStats['padat'] }}</p>
            <p class="text-sm text-gray-500">Padat</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-red-500">
            <p class="text-2xl font-bold text-red-600">{{ $gateStats['macet'] }}</p>
            <p class="text-sm text-gray-500">Macet</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-gray-500">
            <p class="text-2xl font-bold text-gray-600">{{ $gateStats['tutup'] }}</p>
            <p class="text-sm text-gray-500">Tutup</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Gates Management -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Kelola Status Gate</h3>
            </div>
            <div class="card-body">
                @if($gates->isEmpty())
                    <div class="empty-state py-8">
                        <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4"/>
                        </svg>
                        <p class="text-gray-500 mt-3">Belum ada data gate</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($gates as $gate)
                        @php
                            // Determine display status
                            $displayStatus = $gate->status === 'closed' ? 'tutup' : ($gate->traffic_status ?? 'lancar');
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="gate-indicator {{ $displayStatus }}"></div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $gate->nama_gerbang }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($gate->lastUpdatedBy)
                                            Diperbarui oleh {{ $gate->lastUpdatedBy->name }}
                                        @else
                                            Belum ada update
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <form action="{{ route('gates.update', $gate) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="traffic_status" class="form-select text-sm py-1.5 pr-8">
                                    <option value="lancar" {{ $displayStatus == 'lancar' ? 'selected' : '' }}>🟢 Lancar</option>
                                    <option value="padat" {{ $displayStatus == 'padat' ? 'selected' : '' }}>🟡 Padat</option>
                                    <option value="macet" {{ $displayStatus == 'macet' ? 'selected' : '' }}>🔴 Macet</option>
                                    <option value="tutup" {{ $displayStatus == 'tutup' ? 'selected' : '' }}>⚫ Tutup</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Traffic -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Laporkan Kemacetan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('traffic.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" class="form-input" placeholder="Contoh: Depan Gerbang Utama" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Lalu Lintas</label>
                        <select name="status" class="form-select" required>
                            <option value="lancar">🟢 Lancar</option>
                            <option value="padat">🟡 Padat</option>
                            <option value="macet">🔴 Macet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi (opsional)</label>
                        <textarea name="description" class="form-textarea" rows="3" placeholder="Informasi tambahan..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" name="image" class="form-input" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Recent Traffic Updates -->
    <div class="card mb-8">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Update Lalu Lintas Terbaru</h3>
            <a href="{{ route('traffic.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            @if($trafficUpdates->isEmpty())
                <div class="empty-state">
                    <p class="text-gray-500">Belum ada update lalu lintas</p>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Pelapor</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trafficUpdates as $update)
                        <tr>
                            <td class="text-gray-500">{{ $update->created_at->format('d M H:i') }}</td>
                            <td class="font-medium">{{ $update->location }}</td>
                            <td>
                                <span class="badge traffic-{{ $update->status }}">
                                    {{ ucfirst($update->status) }}
                                </span>
                            </td>
                            <td>{{ $update->user->name ?? 'System' }}</td>
                            <td class="text-gray-500">{{ Str::limit($update->description, 30) ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Found Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Barang Temuan</h3>
            <a href="{{ route('lost-found.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($foundItems->isEmpty())
                <div class="empty-state py-8">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 mt-3">Belum ada barang temuan</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($foundItems as $item)
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            @if($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $item->nama_barang }}</p>
                            <p class="text-sm text-gray-500">{{ $item->lokasi_ditemukan }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge badge-info">Ditemukan</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
