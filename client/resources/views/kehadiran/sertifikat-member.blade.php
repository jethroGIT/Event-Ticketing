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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

@section('ExtraJS')
    <script>
        window.onclick = function(event) {
            if (event.target === document.getElementById('uploadModal')) {
                closeModal();
            }
        };
    </script>
@endsection
