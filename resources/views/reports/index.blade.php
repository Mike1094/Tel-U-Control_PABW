<x-app-layout>
    <x-slot name="header">Laporan Kerusakan Fasilitas</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Kelola dan lihat semua laporan kerusakan fasilitas</p>
        </div>
        <a href="{{ route('reports.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Laporan Baru
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="stat-card text-center">
            <p class="text-xl font-bold text-gray-900">{{ $reports->count() }}</p>
            <p class="text-xs text-gray-500">Total</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-xl font-bold text-yellow-600">{{ $reports->where('status', 'pending')->count() }}</p>
            <p class="text-xs text-gray-500">Pending</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-blue-500">
            <p class="text-xl font-bold text-blue-600">{{ $reports->where('status', 'validated')->count() }}</p>
            <p class="text-xs text-gray-500">Validated</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-purple-500">
            <p class="text-xl font-bold text-purple-600">{{ $reports->where('status', 'in_progress')->count() }}</p>
            <p class="text-xs text-gray-500">In Progress</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-xl font-bold text-green-600">{{ $reports->where('status', 'completed')->count() }}</p>
            <p class="text-xs text-gray-500">Completed</p>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Laporan</h3>
        </div>
        <div class="overflow-x-auto">
            @if($reports->isEmpty())
                <div class="empty-state py-12">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada laporan</p>
                    <p class="empty-state-description">Buat laporan pertama Anda tentang kerusakan fasilitas.</p>
                    <a href="{{ route('reports.create') }}" class="btn btn-primary mt-4">Buat Laporan</a>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td class="text-gray-500">{{ $report->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $report->title }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($report->description, 50) }}</div>
                            </td>
                            <td>{{ $report->location }}</td>
                            <td>
                                <span class="badge status-{{ $report->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </td>
                            <td>
                                @if($report->image)
                                    <a href="{{ Storage::url($report->image) }}" target="_blank" rel="noopener noreferrer" class="block relative group">
                                        <img src="{{ Storage::url($report->image) }}" alt="Report image" class="w-12 h-12 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
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
                            <td>
                                <div class="flex items-center space-x-2">
                                    @if(Auth::user()->role == 'admin' && $report->status == 'pending')
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
                                    @elseif(Auth::user()->role == 'admin')
                                    <form action="{{ route('reports.update-status', $report) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select text-xs py-1">
                                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="validated" {{ $report->status == 'validated' ? 'selected' : '' }}>Validated</option>
                                            <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $report->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                    @endif
                                    
                                    @if(Auth::id() == $report->user_id || Auth::user()->role == 'admin')
                                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline text-red-600 hover:bg-red-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
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
