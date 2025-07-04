@extends('layout.layout')
@section('title', 'Events')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-indigo-800">Manajemen Data Events</h1>
                <p class="text-gray-600">Sistem pengelolaan data event</p>
            </div>

            <a href="{{ route('events.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Event
            </a>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Cari berdasarkan nama event...">
                    </div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition-colors">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Users Table Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if (count($events) == 0)
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">
                        @if (request()->has('search'))
                            Data tidak ditemukan
                        @else
                            Belum ada Data Event
                        @endif
                    </h3>
                    <p class="mt-1 text-gray-500">
                        @if (request()->has('search'))
                            Tidak ada data event yang sesuai dengan pencarian Anda.
                        @else
                            Silakan tambahkan data event dengan menekan tombol "Tambah Event" di atas.
                        @endif
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Nama Event</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    TGL. Mulai</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    TGL. Akhir</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Lokasi</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Sesi</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($events as $i => $event)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event['nama_event'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $event['start_event'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event['end_event'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event['lokasi'] }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-4">
                                            <a href="{{ route('sessions.index', $event['id']) }}"
                                                class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Detail Sesi
                                            </a>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-4">
                                            <a href="/events/{{ $event['id'] }}"
                                                class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536M9 11l6.768-6.768a2 2 0 112.828 2.828L11.828 13.828a2 2 0 01-1.414.586H9v-2z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form id="delete-form-{{ $event['id'] }}"
                                                action="{{ route('events.destroy', $event['id']) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('{{ $event['id'] }}')"
                                                    class="text-red-600 hover:text-red-900 flex items-center">
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
                </div>
            @endif
        </div>
    </div>
@endsection

@section('ExtraJS')
    <script>
        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
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
                    document.getElementById('delete-form-' + eventId).submit();
                }
            });
        };

        function toggleSessions(eventId) {
            const section = document.getElementById(`sessions-${eventId}`);
            section.classList.toggle('hidden');
        };
    </script>
@endsection
