@extends('layout.layout')
@section('title', 'Sertifikat Kehadiran')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-indigo-800">Sertifikat Kehadiran</h1>
                <p class="text-gray-600">Daftar kehadiran Anda di berbagai event</p>
            </div>
        </div>

        @if (empty($data['data']) || count($data['data']) === 0)
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada data kehadiran</h3>
                <p class="mt-1 text-gray-500">Anda belum memiliki riwayat kehadiran di event kami.</p>
            </div>
        @else
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Waktu Kehadiran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Sertifikat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data['data'] as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $attendance['nama_event'] }}</td>
                                <td class="px-6 py-4">{{ $attendance['nama_sesi'] }}</td>
                                <td class="px-6 py-4">{{ $attendance['waktu_kehadiran'] ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if (strtolower($attendance['status']) === 'hadir')
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Hadir</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Tidak
                                            Hadir</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (!empty($attendance['sertifikat_url']))
                                        <a href="{{ $attendance['sertifikat_url'] }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    @else
                                        <span class="text-gray-500">Belum tersedia</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (empty($attendance['sertifikat_url']))
                                        <button onclick="openUploadModal('{{ $attendance['id_kehadiran'] }}')"
                                            class="text-indigo-600 hover:text-indigo-900">Upload</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Upload Sertifikat</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="uploadKehadiranId" name="id_kehadiran">
                <div class="mb-4">
                    <label for="sertifikat" class="block text-sm font-medium text-gray-700">File Sertifikat</label>
                    <input type="file" id="sertifikat" name="sertifikat" required
                        class="w-full mt-1 border rounded-md shadow-sm px-3 py-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('ExtraJS')
    <script>
        function openUploadModal(kehadiranId) {
            const form = document.getElementById('uploadForm');
            document.getElementById('uploadKehadiranId').value = kehadiranId;

            // Set form action dinamis
            form.action = `/kehadiran/sertifikat/${kehadiranId}`;

            // Tampilkan modal
            document.getElementById('uploadModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            document.getElementById('uploadForm').reset();
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('uploadModal')) {
                closeModal();
            }
        };
    </script>
@endsection
