<x-app-layout>
    <x-slot name="header">Barang Hilang & Temuan</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Kelola dan lihat laporan barang hilang dan temuan</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('lost-found.create') }}?type=lost" class="btn btn-danger">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Lapor Hilang
            </a>
            <a href="{{ route('lost-found.create') }}?type=found" class="btn btn-success">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Lapor Temuan
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card text-center border-l-4 border-l-red-500">
            <p class="text-xl font-bold text-red-600">{{ $items->where('type', 'lost')->count() }}</p>
            <p class="text-xs text-gray-500">Barang Hilang</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-blue-500">
            <p class="text-xl font-bold text-blue-600">{{ $items->where('type', 'found')->count() }}</p>
            <p class="text-xs text-gray-500">Barang Temuan</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-xl font-bold text-yellow-600">{{ $items->where('status', 'pending')->count() }}</p>
            <p class="text-xs text-gray-500">Pending</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-xl font-bold text-green-600">{{ $items->where('status', 'claimed')->count() }}</p>
            <p class="text-xs text-gray-500">Diklaim</p>
        </div>
    </div>

    <!-- Items Grid -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Barang</h3>
        </div>
        <div class="card-body">
            @if($items->isEmpty())
                <div class="empty-state py-12">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada data barang</p>
                    <p class="empty-state-description">Laporkan barang hilang atau temuan Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($items as $item)
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow {{ $item->type == 'lost' ? 'hover:border-red-300' : 'hover:border-blue-300' }}">
                        <!-- Image -->
                        <div class="aspect-video bg-gray-100 relative">
                            @if($item->image)
                                <a href="{{ Storage::url($item->image) }}" target="_blank" rel="noopener noreferrer" class="block w-full h-full group">
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <div class="bg-white/90 rounded-full p-3">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div class="w-full h-full flex items-center justify-center {{ $item->type == 'lost' ? 'bg-red-50' : 'bg-blue-50' }}">
                                    <svg class="w-16 h-16 {{ $item->type == 'lost' ? 'text-red-300' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="badge {{ $item->type == 'lost' ? 'badge-danger' : 'badge-info' }} text-sm">
                                    {{ $item->type == 'lost' ? 'HILANG' : 'DITEMUKAN' }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-secondary text-xs">{{ ucfirst($item->status) }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $item->item_name }}</h4>
                            <p class="text-sm text-gray-500 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $item->location }}
                            </p>
                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $item->description }}</p>
                            
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <div class="avatar avatar-sm">{{ substr($item->user->name, 0, 1) }}</div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-900">{{ $item->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-1">
                                    @if($item->type == 'lost' && $item->status == 'open' && Auth::id() != $item->user_id)
                                        <a href="{{ route('lost-found.create') }}?type=found&linked_lost_id={{ $item->id }}" class="btn btn-sm btn-success" title="Saya menemukan ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    @if(Auth::id() == $item->user_id && $item->status != 'resolved')
                                        <form action="{{ route('lost-found.update', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline" title="Tandai selesai">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if(Auth::id() == $item->user_id || Auth::user()->role == 'admin')
                                        <form action="{{ route('lost-found.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline text-red-600 hover:bg-red-50" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
