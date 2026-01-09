<x-app-layout>
    <x-slot name="header">Lalu Lintas & Status Gate</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Gate Status -->
        <div class="lg:col-span-2">
            <div class="card h-full">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900">Status Gate Kampus</h3>
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'satpam')
                        <a href="{{ route('admin.gates.index') }}" class="btn btn-sm btn-outline-primary">Kelola Gate</a>
                    @endif
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($gates as $gate)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        {{ $gate->status == 'closed' ? 'bg-gray-100' : ($gate->traffic_status == 'lancar' ? 'bg-green-100' : ($gate->traffic_status == 'padat' ? 'bg-yellow-100' : 'bg-red-100')) }}">
                                        <svg class="w-6 h-6 
                                            {{ $gate->status == 'closed' ? 'text-gray-600' : ($gate->traffic_status == 'lancar' ? 'text-green-600' : ($gate->traffic_status == 'padat' ? 'text-yellow-600' : 'text-red-600')) }}" 
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $gate->nama_gerbang }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $gate->status == 'closed' ? 'Tutup' : ucfirst($gate->traffic_status ?? 'lancar') }}
                                        </p>
                                    </div>
                                </div>
                                
                                @if((Auth::user()->role == 'admin' || Auth::user()->role == 'satpam') && $gate->status == 'open')
                                <form action="{{ route('gates.update', $gate) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="traffic_status" onchange="this.form.submit()" class="form-select text-sm py-1.5">
                                        <option value="lancar" {{ ($gate->traffic_status ?? '') == 'lancar' ? 'selected' : '' }}>🟢 Lancar</option>
                                        <option value="padat" {{ ($gate->traffic_status ?? '') == 'padat' ? 'selected' : '' }}>🟡 Padat</option>
                                        <option value="macet" {{ ($gate->traffic_status ?? '') == 'macet' ? 'selected' : '' }}>🔴 Macet</option>
                                    </select>
                                </form>
                                @else
                                <span class="badge traffic-{{ $gate->status == 'closed' ? 'tutup' : ($gate->traffic_status ?? 'lancar') }} text-sm">
                                    {{ $gate->status == 'closed' ? 'Tutup' : ucfirst($gate->traffic_status ?? 'lancar') }}
                                </span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Report Traffic Form -->
        @if(Auth::user()->role != 'warga')
        <div class="card h-full">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Laporkan Kemacetan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('traffic.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" class="form-input" placeholder="Contoh: Depan Gerbang Utama" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="lancar">🟢 Lancar</option>
                            <option value="padat">🟡 Padat</option>
                            <option value="macet">🔴 Macet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-textarea" rows="2" placeholder="Info tambahan..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto</label>
                        <input type="file" name="image" class="form-input text-sm" accept="image/*">
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
        @endif
    </div>

    <!-- Traffic Updates -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Update Lalu Lintas Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            @if($trafficUpdates->isEmpty())
                <div class="empty-state py-12">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada update lalu lintas</p>
                    <p class="empty-state-description">Update lalu lintas akan muncul di sini.</p>
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
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trafficUpdates as $update)
                        <tr>
                            <td class="text-gray-500">{{ $update->created_at->format('d M Y H:i') }}</td>
                            <td class="font-medium">{{ $update->location }}</td>
                            <td>
                                <span class="badge traffic-{{ $update->status }}">
                                    {{ ucfirst($update->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div class="avatar avatar-sm">{{ substr($update->user->name ?? 'S', 0, 1) }}</div>
                                    <span>{{ $update->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="text-gray-500 max-w-xs truncate">{{ $update->description ?? '-' }}</td>
                            <td>
                                @if($update->image)
                                    <a href="{{ Storage::url($update->image) }}" target="_blank" rel="noopener noreferrer" class="block relative group">
                                        <img src="{{ Storage::url($update->image) }}" alt="Traffic" class="w-12 h-12 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                                        <div class="absolute inset-0 bg-black/50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </div>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
