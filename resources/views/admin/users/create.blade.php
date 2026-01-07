<x-app-layout>
    <x-slot name="header">Tambah Pengguna Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Form Tambah Pengguna</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" placeholder="Nama lengkap pengguna" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror" 
                               value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role-select" class="form-select @error('role') border-red-500 @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="satpam" {{ old('role') == 'satpam' ? 'selected' : '' }}>Satpam</option>
                            <option value="civitas" {{ old('role') == 'civitas' ? 'selected' : '' }}>Civitas Akademika</option>
                            <option value="warga" {{ old('role') == 'warga' ? 'selected' : '' }}>Warga Sekitar</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group" id="sub-role-group" style="display: none;">
                        <label class="form-label">Sub Role (Untuk Civitas)</label>
                        <select name="sub_role" class="form-select">
                            <option value="">-- Pilih Sub Role --</option>
                            <option value="dosen" {{ old('sub_role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="mahasiswa" {{ old('sub_role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIM/NIP</label>
                        <input type="text" name="nim_nip" class="form-input" 
                               value="{{ old('nim_nip') }}" placeholder="NIM untuk mahasiswa, NIP untuk dosen/pegawai">
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-input" 
                               value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="form-input @error('password') border-red-500 @enderror" 
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="form-input" 
                               placeholder="Ulangi password" required>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role-select').addEventListener('change', function() {
            const subRoleGroup = document.getElementById('sub-role-group');
            if (this.value === 'civitas') {
                subRoleGroup.style.display = 'block';
            } else {
                subRoleGroup.style.display = 'none';
            }
        });

        // Check on page load
        if (document.getElementById('role-select').value === 'civitas') {
            document.getElementById('sub-role-group').style.display = 'block';
        }
    </script>
</x-app-layout>
