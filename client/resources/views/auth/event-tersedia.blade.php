<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPro - Event Tersedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4a00e0;
            --secondary: #8e2de2;
            --accent: #ff6b6b;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-indigo-800">EventPro</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('signup') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-indigo-800">Event Tersedia</h1>
                <p class="text-gray-600">Temukan event menarik untuk Anda ikuti</p>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search"
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                @php
                    $endEvent = \Carbon\Carbon::parse($event['end_event']);
                    $isPast = $endEvent->isPast();
                @endphp

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow {{ $isPast ? 'opacity-60' : '' }}">
                    <!-- Event Poster -->
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $event['poster_url'] }}" alt="{{ $event['nama_event'] }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Event Details -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-xl font-bold text-gray-800">
                                {{ $event['nama_event'] }}
                                @if ($isPast)
                                    <span class="text-sm text-red-500 font-normal">(Sudah Berakhir)</span>
                                @endif
                            </h2>
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                Rp{{ number_format($event['biaya_registrasi']) }}
                            </span>
                        </div>

                        <div class="flex items-center text-gray-600 text-sm mb-2">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>
                                {{ \Carbon\Carbon::parse($event['start_event'])->format('d M Y') }} -
                                {{ $endEvent->format('d M Y') }}
                            </span>
                        </div>

                        <div class="flex items-center text-gray-600 text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $event['lokasi'] }}</span>
                        </div>

                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-user-tie mr-2"></i>
                            <span>{{ $event['narasumber'] }}</span>
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $event['deskripsi'] }}</p>

                        <!-- Event Sessions -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Sesi Event:</h3>
                            @if (!empty($event['EventSessions']))
                                <ul class="space-y-1">
                                    @foreach ($event['EventSessions'] as $sesi)
                                        <li class="text-xs text-gray-600">
                                            <i class="fas fa-circle-notch text-indigo-500 mr-1"></i>
                                            {{ $sesi['nama_sesi'] }} -
                                            {{ \Carbon\Carbon::parse($sesi['tanggal'])->format('d M Y') }}
                                            ({{ substr($sesi['jam_mulai'], 0, 5) }} - {{ substr($sesi['jam_selesai'], 0, 5) }})
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-gray-500">Belum ada sesi</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            @if (!$isPast)
                                <a href="{{ route('login') }}"
                                   class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                    Daftar Sekarang
                                </a>
                            @else
                                <div
                                    class="flex-1 text-center bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                    Ditutup
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; 2023 EventPro. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#4a00e0',
                    scrollbarPadding: false,
                    didOpen: () => {
                        document.body.style.overflow = 'hidden';
                    },
                    willClose: () => {
                        document.body.style.overflow = '';
                    }
                });
            });
        </script>
    @endif
</body>
</html>
