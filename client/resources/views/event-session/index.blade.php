@extends('layout.layout')
@section('title', 'Sesi Event')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-indigo-800">Manajemen Sesi Event</h1>
                <p class="text-gray-600 mt-1">Sistem Pengelolaan Sesi Event {{ $id }}</p>
            </div>

            <button onclick="openModal('addModal')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Sesi
            </button>
        </div>

        <!-- Modal Add Session -->
        <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-indigo-800">Tambah Sesi Baru</h2>
                    <button onclick="closeModal('addModal')" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('sessions.store', ['id' => $id]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi</label>
                        <input type="text" name="nama_sesi" id="nama_sesi" required
                            class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" required
                            class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" required
                                class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" required
                                class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('addModal')"
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Sessions Table Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            @if (isset($api_error))
                <div class="p-8 text-center">
                    <div class="mx-auto w-24 h-24 text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mt-4">Terjadi Kesalahan</h3>
                    <p class="mt-2 text-red-600">{{ $api_error }}</p>
                    <button onclick="window.location.reload()"
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors flex items-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd" />
                        </svg>
                        Refresh
                    </button>
                </div>
            @elseif (count($sessions) == 0)
                <div class="p-8 text-center">
                    <div class="mx-auto w-24 h-24 text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mt-4">Belum ada sesi</h3>
                    <p class="mt-2 text-gray-500">Anda belum menambahkan sesi untuk event ini.</p>
                    <a href=""
                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Sesi Pertama
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Nama Sesi
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Waktu Mulai
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Waktu Selesai
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sessions as $session)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $session['nama_sesi'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $session['tanggal'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $session['jam_mulai'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $session['jam_selesai'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex space-x-3">
                                            <button
                                                onclick="openEditModal(
                                                    '{{ $session['id'] }}', 
                                                    '{{ $session['nama_sesi'] }}',
                                                    '{{ $session['tanggal'] }}',
                                                    '{{ $session['jam_mulai'] }}',
                                                    '{{ $session['jam_selesai'] }}'
                                                )"
                                                class="flex items-center text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536M9 11l6.768-6.768a2 2 0 112.828 2.828L11.828 13.828a2 2 0 01-1.414.586H9v-2z" />
                                                </svg>
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form id="delete-form-{{ $session['id'] }}"
                                                action="{{ route('sessions.destroy', ['id' => $session['id']]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $session['id'] }})"
                                                    class="flex items-center text-red-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                </div>

                <!-- Modal Edit Session -->
                <div id="editModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white rounded-xl p-6 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-indigo-800">Edit Sesi</h2>
                            <button onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form id="editSessionForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_nama_sesi" class="block text-sm font-medium text-gray-700">Nama
                                    Sesi</label>
                                <input type="text" name="nama_sesi" id="edit_nama_sesi" required
                                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="mb-4">
                                <label for="edit_tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="tanggal" id="edit_tanggal" required
                                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="edit_jam_mulai" class="block text-sm font-medium text-gray-700">Waktu
                                        Mulai</label>
                                    <input type="time" name="jam_mulai" id="edit_jam_mulai" required
                                        class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="edit_jam_selesai" class="block text-sm font-medium text-gray-700">Waktu
                                        Selesai</label>
                                    <input type="time" name="jam_selesai" id="edit_jam_selesai" required
                                        class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="closeModal('editModal')"
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md">Kembali</a>
        </div>
    </div>
@endsection


@section('ExtraJS')
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Optional: Klik di luar modal untuk menutup
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const addModal = document.getElementById('addModal');

            if (event.target === editModal) {
                closeModal('editModal');
            }
            if (event.target === addModal) {
                closeModal('addModal');
            }
        }

        // Fungsi untuk membuka modal edit dan isi data
        function openEditModal(id, namaSesi, tanggal, jamMulai, jamSelesai) {
            openModal('editModal');
            document.getElementById('edit_nama_sesi').value = namaSesi;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_jam_mulai').value = jamMulai;
            document.getElementById('edit_jam_selesai').value = jamSelesai;

            // Atur form action
            document.getElementById('editSessionForm').action = `/events/sessions/${id}`;
        }

        function confirmDelete(sessionId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Sesi ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + sessionId).submit();
                }
            });
        }
    </script>
@endsection
