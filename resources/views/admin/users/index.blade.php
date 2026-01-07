<x-app-layout>
    <x-slot name="header">Kelola Pengguna</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Kelola semua akun pengguna sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="stat-card text-center">
            <p class="text-xl font-bold text-gray-900">{{ $users->count() }}</p>
            <p class="text-xs text-gray-500">Total User</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-red-500">
            <p class="text-xl font-bold text-red-600">{{ $users->where('role', 'admin')->count() }}</p>
            <p class="text-xs text-gray-500">Admin</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-yellow-500">
            <p class="text-xl font-bold text-yellow-600">{{ $users->where('role', 'satpam')->count() }}</p>
            <p class="text-xs text-gray-500">Satpam</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-blue-500">
            <p class="text-xl font-bold text-blue-600">{{ $users->where('role', 'civitas')->count() }}</p>
            <p class="text-xs text-gray-500">Civitas</p>
        </div>
        <div class="stat-card text-center border-l-4 border-l-green-500">
            <p class="text-xl font-bold text-green-600">{{ $users->where('role', 'warga')->count() }}</p>
            <p class="text-xs text-gray-500">Warga</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Sub Role</th>
                        <th>NIM/NIP</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar avatar-sm role-badge-{{ $user->role }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-gray-500">{{ $user->email }}</td>
                        <td>
                            <span class="badge role-badge-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->sub_role)
                                <span class="badge badge-secondary">{{ ucfirst($user->sub_role) }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td>{{ $user->nim_nip ?? '-' }}</td>
                        <td class="text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
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
        </div>
    </div>
</x-app-layout>
