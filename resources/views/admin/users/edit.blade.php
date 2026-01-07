<x-app-layout>
    <x-slot name="header">Edit Pengguna</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Edit Data Pengguna</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role-select" class="form-select @error('role') border-red-500 @enderror" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="satpam" {{ old('role', $user->role) == 'satpam' ? 'selected' : '' }}>Satpam</option>
                            <option value="civitas" {{ old('role', $user->role) == 'civitas' ? 'selected' : '' }}>Civitas Akademika</option>
                            <option value="warga" {{ old('role', $user->role) == 'warga' ? 'selected' : '' }}>Warga Sekitar</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group" id="sub-role-group" style="{{ old('role', $user->role) == 'civitas' ? '' : 'display: none;' }}">
                        <label class="form-label">Sub Role (Untuk Civitas)</label>
                        <select name="sub_role" class="form-select">
                            <option value="">-- Pilih Sub Role --</option>
                            <option value="dosen" {{ old('sub_role', $user->sub_role) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="mahasiswa" {{ old('sub_role', $user->sub_role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIM/NIP</label>
                        <input type="text" name="nim_nip" class="form-input" 
                               value="{{ old('nim_nip', $user->nim_nip) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-input" 
                               value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-4">
                        <p class="text-sm text-yellow-800 font-medium">Ganti Password (opsional)</p>
                        <p class="text-xs text-yellow-600">Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-input @error('password') border-red-500 @enderror" 
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-input">
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
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

    <script>
        document.getElementById('role-select').addEventListener('change', function() {
            const subRoleGroup = document.getElementById('sub-role-group');
            if (this.value === 'civitas') {
                subRoleGroup.style.display = 'block';
            } else {
                subRoleGroup.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
