@extends('layout.layout')
@section('title', 'Order Tiket')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-indigo-800">Order Tiket Saya</h1>
            <p class="text-gray-600">Daftar tiket yang sudah Anda pesan</p>
        </div>

        @if (count($orders) === 0)
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada tiket</h3>
                <p class="mt-1 text-gray-500">Anda belum memesan tiket event apapun.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Order #{{ $order['id'] }}</h3>
                                <p class="text-sm text-gray-500">
                                    Tanggal order: {{ date('d M Y H:i', strtotime($order['created_at'])) }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                @if ($order['Pembayaran'][0]['status_pembayaran'] === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                        Menunggu Pembayaran
                                    </span>
                                @elseif($order['Pembayaran'][0]['status_pembayaran'] === 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        Sudah Dibayar
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                        {{ ucfirst($order['Pembayaran'][0]['status_pembayaran']) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Content -->
                        <div class="p-6">
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 mb-2">Detail Pembayaran</h4>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Metode Pembayaran</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            @if ($order['Pembayaran'][0]['tipe_pembayaran'] === 'transfer')
                                                Transfer Bank
                                            @elseif($order['Pembayaran'][0]['tipe_pembayaran'] === 'qris')
                                                QRIS
                                            @else
                                                COD (Cash on Delivery)
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($order['Pembayaran'][0]['status_pembayaran']) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Tiket</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ count($order['Tiket']) }} tiket
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Biaya</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            Rp
                                            {{ number_format($order['Tiket'][0]['EventSessions']['Events']['biaya_registrasi'] * count($order['Tiket']), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <h4 class="text-md font-medium text-gray-900 mb-4">Daftar Tiket</h4>
                            <div class="space-y-4">
                                @foreach ($order['Tiket'] as $tiket)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h5 class="font-semibold text-gray-900">
                                                    {{ $tiket['EventSessions']['nama_sesi'] }}</h5>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    <svg class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ date('d M Y', strtotime($tiket['EventSessions']['Events']['start_event'])) }}
                                                    |
                                                    <svg class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $tiket['EventSessions']['jam_mulai'] }} -
                                                    {{ $tiket['EventSessions']['jam_selesai'] }}
                                                </p>
                                            </div>
                                            <span
                                                class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                ID: {{ $tiket['id'] }}
                                            </span>
                                        </div>

                                        <div class="mt-3">
                                            <p class="text-sm text-gray-800">
                                                <span class="font-medium">Event:</span>
                                                {{ $tiket['EventSessions']['Events']['nama_event'] }}
                                            </p>
                                            <p class="text-sm text-gray-800">
                                                <span class="font-medium">Lokasi:</span>
                                                {{ $tiket['EventSessions']['Events']['lokasi'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                            @if ($order['Pembayaran'][0]['status_pembayaran'] === 'pending')
                                <!-- FORM BATAL DI LUAR FORM UTAMA -->
                                <form id="delete-form-{{ $order['id'] }}"
                                    action="{{ route('orders.cancel', ['order_id' => $order['id']]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmCancel({{ $order['id'] }})"
                                        class="bg-red-100 hover:bg-red-200 text-red-600 font-medium py-2 px-6 rounded-lg transition-colors flex items-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan Order
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('ExtraJS')
    <script>
        function confirmCancel(orderId) {
            Swal.fire({
                title: 'Batalkan Order?',
                text: "Anda tidak dapat mengembalikan order yang sudah dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + orderId).submit();
                }
            });
        }
    </script>
@endsection
