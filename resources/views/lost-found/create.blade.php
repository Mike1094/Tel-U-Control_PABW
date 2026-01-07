<x-app-layout>
    <x-slot name="header">
        {{ isset($type) && $type == 'found' ? 'Laporkan Barang Temuan' : 'Laporkan Barang Hilang' }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">
                    Form Laporan Barang {{ isset($type) && $type == 'found' ? 'Temuan' : 'Hilang' }}
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('lost-found.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Tipe Laporan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                {{ (old('type', $type ?? 'lost') == 'lost') ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input type="radio" name="type" value="lost" class="sr-only" {{ (old('type', $type ?? 'lost') == 'lost') ? 'checked' : '' }}>
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 {{ (old('type', $type ?? 'lost') == 'lost') ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium {{ (old('type', $type ?? 'lost') == 'lost') ? 'text-red-700' : 'text-gray-700' }}">Barang Hilang</span>
                                    <p class="text-xs text-gray-500 mt-1">Saya kehilangan barang</p>
                                </div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                {{ (old('type', $type ?? 'lost') == 'found') ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input type="radio" name="type" value="found" class="sr-only" {{ (old('type', $type ?? 'lost') == 'found') ? 'checked' : '' }}>
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 {{ (old('type', $type ?? 'lost') == 'found') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="font-medium {{ (old('type', $type ?? 'lost') == 'found') ? 'text-blue-700' : 'text-gray-700' }}">Barang Temuan</span>
                                    <p class="text-xs text-gray-500 mt-1">Saya menemukan barang</p>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="item_name" class="form-input @error('item_name') border-red-500 @enderror" 
                               value="{{ old('item_name') }}" placeholder="Contoh: Dompet Hitam, HP Samsung, dll" required>
                        @error('item_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" class="form-input @error('location') border-red-500 @enderror" 
                               value="{{ old('location') }}" placeholder="Contoh: Kantin Gedung A, Parkiran, dll" required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" class="form-textarea @error('description') border-red-500 @enderror" 
                                  rows="4" placeholder="Jelaskan ciri-ciri barang secara detail..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(isset($lostItems) && $lostItems->isNotEmpty() && (old('type', $type ?? '') == 'found'))
                    <div class="form-group" id="linked-lost-section">
                        <label class="form-label">Terkait dengan Laporan Hilang (opsional)</label>
                        <select name="linked_lost_id" class="form-select">
                            <option value="">-- Pilih jika barang ini cocok dengan laporan yang ada --</option>
                            @foreach($lostItems as $lostItem)
                                <option value="{{ $lostItem->id }}" {{ old('linked_lost_id', $linked_lost_id ?? '') == $lostItem->id ? 'selected' : '' }}>
                                    {{ $lostItem->item_name }} - {{ $lostItem->location }} ({{ $lostItem->user->name }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Jika barang yang Anda temukan cocok dengan laporan kehilangan yang ada, pilih di sini.</p>
                    </div>
                    @endif

                    @if(isset($linked_lost_id) && $linked_lost_id)
                        <input type="hidden" name="linked_lost_id" value="{{ $linked_lost_id }}">
                    @endif

                    <div class="form-group">
                        <label class="form-label">Foto Barang (opsional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-red-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer rounded-md font-medium text-red-600 hover:text-red-500">
                                        <span>Upload file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('lost-found.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle radio button styling
        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="type"]').forEach(r => {
                    r.closest('label').classList.remove('border-red-500', 'bg-red-50', 'border-blue-500', 'bg-blue-50');
                    r.closest('label').classList.add('border-gray-200');
                });
                if (this.value === 'lost') {
                    this.closest('label').classList.add('border-red-500', 'bg-red-50');
                } else {
                    this.closest('label').classList.add('border-blue-500', 'bg-blue-50');
                }
            });
        });
    </script>
</x-app-layout>
