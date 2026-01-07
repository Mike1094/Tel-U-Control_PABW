<x-app-layout>
    <x-slot name="header">Tambah CCTV Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Form Tambah CCTV</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.cctv.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama CCTV <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" placeholder="Contoh: Gerbang Utama Cam 1" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" class="form-input @error('location') border-red-500 @enderror" 
                               value="{{ old('location') }}" placeholder="Contoh: Pintu Masuk Utama" required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select @error('status') border-red-500 @enderror" required>
                            <option value="online" {{ old('status') == 'online' ? 'selected' : '' }}>🟢 Online</option>
                            <option value="offline" {{ old('status') == 'offline' ? 'selected' : '' }}>🔴 Offline</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>🟡 Maintenance</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stream URL (opsional)</label>
                        <input type="url" name="stream_url" class="form-input @error('stream_url') border-red-500 @enderror" 
                               value="{{ old('stream_url') }}" placeholder="https://example.com/stream.m3u8">
                        @error('stream_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi (opsional)</label>
                        <textarea name="description" class="form-textarea" rows="3" placeholder="Deskripsi tambahan...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Thumbnail (opsional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-red-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="thumbnail" class="relative cursor-pointer rounded-md font-medium text-red-600 hover:text-red-500">
                                        <span>Upload file</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG maksimal 2MB</p>
                            </div>
                        </div>
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.cctv.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah CCTV
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
