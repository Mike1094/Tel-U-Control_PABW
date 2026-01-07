<x-app-layout>
    <x-slot name="header">CCTV Sekitar</x-slot>

    <div class="mb-6">
        <p class="text-gray-500">Pantau kondisi sekitar kampus melalui CCTV yang tersedia</p>
    </div>

    @if($cctvs->isEmpty())
        <div class="card">
            <div class="empty-state py-12">
                <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <p class="empty-state-title">Tidak ada CCTV tersedia</p>
                <p class="empty-state-description">CCTV online akan muncul di sini.</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cctvs as $cctv)
            <a href="{{ $cctv->stream_url ?? ($cctv->thumbnail ? Storage::url($cctv->thumbnail) : '#') }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="card overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow block">
                <div class="aspect-video bg-gray-900 relative">
                    @if($cctv->thumbnail)
                        <img src="{{ Storage::url($cctv->thumbnail) }}" alt="{{ $cctv->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 text-sm mt-2">Live Feed</p>
                        </div>
                    @endif
                    
                    <!-- Live Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 text-white shadow-lg">
                            <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                            LIVE
                        </span>
                    </div>

                    <!-- Overlay on hover -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="bg-white/90 rounded-full p-4">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900">{{ $cctv->name }}</h3>
                    <p class="text-sm text-gray-500 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $cctv->location }}
                    </p>
                    @if($cctv->description)
                        <p class="text-xs text-gray-400 mt-2">{{ $cctv->description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <!-- Info Box -->
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-medium text-blue-800">Informasi</p>
                    <p class="text-sm text-blue-700 mt-1">
                        CCTV tersedia untuk memantau kondisi sekitar kampus. Klik pada preview untuk melihat live stream (jika tersedia).
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
