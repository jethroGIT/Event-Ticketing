@extends('layout.layout')
@section('title', 'Manajemen Role')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-indigo-800">Manajemen Role</h1>
                <p class="text-gray-600">Sistem pengelolaan data role pengguna</p>
            </div>
            <button onclick="openAddModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Role
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            @if (count($roles) == 0)
                <div class="p-8 text-center text-gray-600">Belum ada data role.</div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Nama Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Created at</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Updated at</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($roles as $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $role['id'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $role['nama_role'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($role['created_at'])->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($role['updated_at'])->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex space-x-3">
                                        <button onclick="openEditModal({{ $role['id'] }}, '{{ $role['nama_role'] }}')"
                                            class="flex items-center text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 11l6.768-6.768a2 2 0 112.828 2.828L11.828 13.828a2 2 0 01-1.414.586H9v-2z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <form action="{{ route('roles.destroy', $role['id']) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Modal Add -->
    <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Tambah Role</h2>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama_role" class="block text-sm font-medium text-gray-700">Nama Role</label>
                    <input type="text" name="nama_role" id="nama_role" required
                        class="w-full border border-gray-300 rounded-lg p-2 mt-1">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 text-gray-700 border rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Edit Role</h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_nama_role" class="block text-sm font-medium text-gray-700">Nama Role</label>
                    <input type="text" name="nama_role" id="edit_nama_role" required
                        class="w-full border border-gray-300 rounded-lg p-2 mt-1">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-gray-700 border rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('ExtraJS')
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id, nama) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
            document.getElementById('edit_nama_role').value = nama;
            let form = document.getElementById('editRoleForm');
            form.action = `/roles/${id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endsection
