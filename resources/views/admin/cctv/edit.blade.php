<x-app-layout>
    <x-slot name="header">Edit CCTV</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Edit Data CCTV</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.cctv.update', $cctv) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama CCTV <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name', $cctv->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" class="form-input @error('location') border-red-500 @enderror" 
                               value="{{ old('location', $cctv->location) }}" required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select @error('status') border-red-500 @enderror" required>
                            <option value="online" {{ old('status', $cctv->status) == 'online' ? 'selected' : '' }}>🟢 Online</option>
                            <option value="offline" {{ old('status', $cctv->status) == 'offline' ? 'selected' : '' }}>🔴 Offline</option>
                            <option value="maintenance" {{ old('status', $cctv->status) == 'maintenance' ? 'selected' : '' }}>🟡 Maintenance</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stream URL (opsional)</label>
                        <input type="url" name="stream_url" class="form-input @error('stream_url') border-red-500 @enderror" 
                               value="{{ old('stream_url', $cctv->stream_url) }}">
                        @error('stream_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi (opsional)</label>
                        <textarea name="description" class="form-textarea" rows="3">{{ old('description', $cctv->description) }}</textarea>
                    </div>

                    @if($cctv->thumbnail)
                    <div class="form-group">
                        <label class="form-label">Thumbnail Saat Ini</label>
                        <div class="w-40 h-24 bg-gray-800 rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($cctv->thumbnail) }}" alt="{{ $cctv->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Ganti Thumbnail (opsional)</label>
                        <input type="file" name="thumbnail" class="form-input" accept="image/*">
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.cctv.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
