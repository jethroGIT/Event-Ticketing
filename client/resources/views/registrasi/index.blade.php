@extends('layout.layout')
@section('title', 'Registrasi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-1">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-indigo-800">Registrasi Event</h1>
                <p class="text-gray-600">Pilih event yang tersedia untuk mendaftar</p>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"/>
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

        <!-- Event Cards -->
        @if (count($events) === 0)
            <div class="p-8 text-center bg-white rounded-xl shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    @if (request()->has('search') && !empty(request('search')))
                        Event dengan nama "{{ request('search') }}" tidak ditemukan.
                    @else
                        Belum ada event tersedia
                    @endif
                </h3>
                <p class="mt-1 text-gray-500">
                    @if (request()->has('search') && !empty(request('search')))
                        Silakan coba dengan kata kunci lain.
                    @else
                        Silakan cek kembali nanti.
                    @endif
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    @php
                        $now = \Carbon\Carbon::now();
                        $endEvent = \Carbon\Carbon::parse($event['end_event']);
                        $startEvent = \Carbon\Carbon::parse($event['start_event']);
                        $isPast = $endEvent->isPast();
                    @endphp

                    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between {{ $isPast ? 'opacity-60' : '' }}">
                        <div>
                            <h2 class="text-xl font-bold text-indigo-700 mb-2">
                                {{ $event['nama_event'] }}
                                @if ($isPast)
                                    <span class="text-sm text-red-600 font-normal">(Sudah Berakhir)</span>
                                @endif
                            </h2>
                            <div class="mb-2">
                                <img src="{{ $event['poster_url'] }}" alt="Poster Event"
                                     class="h-40 object-contain border rounded-md w-full">
                            </div>
                            <p class="text-sm text-gray-600 mb-1"><strong>Tanggal:</strong>
                                {{ $startEvent->format('d M Y') }} - {{ $endEvent->format('d M Y') }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Lokasi:</strong> {{ $event['lokasi'] }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Narasumber:</strong>
                                {{ $event['narasumber'] }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Biaya:</strong>
                                Rp{{ number_format($event['biaya_registrasi']) }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Peserta Maksimal:</strong>
                                {{ $event['maks_peserta'] }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Deskripsi:</strong></p>
                            <p class="text-sm text-gray-600 mb-3">{{ $event['deskripsi'] }}</p>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-700 mb-1">Sesi:</h3>
                                @if (!empty($event['EventSessions']))
                                    <ul class="list-disc list-inside text-sm text-gray-600">
                                        @foreach ($event['EventSessions'] as $sesi)
                                            <li>
                                                {{ $sesi['nama_sesi'] }} -
                                                {{ \Carbon\Carbon::parse($sesi['tanggal'])->format('d M Y') }}
                                                ({{ substr($sesi['jam_mulai'], 0, 5) }} -
                                                {{ substr($sesi['jam_selesai'], 0, 5) }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500">Belum ada sesi.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Tombol Registrasi -->
                        <div class="mt-4">
                            @if (!$isPast)
                                <form action="{{ route('registrasi') }}" method="POST">
                                    <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                                    @csrf
                                    <button type="submit">
                                        <div
                                            class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                                            Daftar Sekarang
                                        </div>
                                    </button>
                                </form>
                            @else
                                <p class="text-red-500 text-center font-semibold">Pendaftaran ditutup</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('ExtraJS')
    <!-- Tambahan JS jika diperlukan -->
@endsection
