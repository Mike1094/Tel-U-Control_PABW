<x-app-layout>
    <x-slot name="header">Tambah Gate Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Form Tambah Gate</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.gates.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Gate <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" placeholder="Contoh: Gerbang Utama, Gerbang Belakang" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select @error('status') border-red-500 @enderror" required>
                            <option value="lancar" {{ old('status') == 'lancar' ? 'selected' : '' }}>🟢 Lancar</option>
                            <option value="padat" {{ old('status') == 'padat' ? 'selected' : '' }}>🟡 Padat</option>
                            <option value="macet" {{ old('status') == 'macet' ? 'selected' : '' }}>🔴 Macet</option>
                            <option value="tutup" {{ old('status') == 'tutup' ? 'selected' : '' }}>⚫ Tutup</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.gates.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Gate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
