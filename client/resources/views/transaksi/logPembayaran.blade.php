@extends('layout.layout')
@section('title', 'Manajemen Pesanan Tiket')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-indigo-800">Manajemen Pesanan Tiket</h1>
                <p class="text-gray-600">Kelola status pembayaran pesanan tiket dari pelanggan</p>
            </div>
        </div>

        @if (count($orders) === 0)
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                <p class="mt-1 text-gray-500">Tidak ada pesanan tiket yang perlu dikelola saat ini.</p>
            </div>
        @else
            <!-- Table Content -->
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                ID Pesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Jumlah Tiket
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Pembayaran
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Bukti
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order['id'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ date('d M Y H:i', strtotime($order['created_at'])) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ count($order['Tiket']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($order['Pembayaran'][0]['tipe_pembayaran'] === 'transfer')
                                        Transfer Bank
                                    @elseif($order['Pembayaran'][0]['tipe_pembayaran'] === 'qris')
                                        QRIS
                                    @else
                                        COD
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order['Pembayaran'][0]['status_pembayaran'] === 'pending')
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                            Pending
                                        </span>
                                    @elseif($order['Pembayaran'][0]['status_pembayaran'] === 'confirmed')
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Confirmed
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                            {{ ucfirst($order['Pembayaran'][0]['status_pembayaran']) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if (!empty($order['Pembayaran'][0]['bukti_pembayaran']))
                                        <button onclick="showProof('{{ $order['Pembayaran'][0]['bukti_pembayaran'] }}')"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            Lihat
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                    @if ($order['Pembayaran'][0]['status_pembayaran'] === 'pending')
                                        <div class="flex space-x-2">
                                            <!-- Tombol Konfirmasi -->
                                            <form
                                                action="{{ route('orders.update', ['id' => $order['Pembayaran'][0]['id']]) }}"
                                                method="POST" class="inline" onsubmit="return confirmPayment(this)">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_pembayaran" value="confirmed">
                                                <button type="submit"
                                                    class="flex items-center text-green-600 hover:text-green-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Konfirmasi
                                                </button>
                                            </form>

                                            <!-- Tombol Tolak -->
                                            <form
                                                action="{{ route('orders.update', ['id' => $order['Pembayaran'][0]['id']]) }}"
                                                method="POST" class="inline" onsubmit="return rejectPayment(this)">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_pembayaran" value="rejected">
                                                <button type="submit"
                                                    class="flex items-center text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-500">
                                            {{ $order['Pembayaran'][0]['status_pembayaran'] === 'confirmed' ? 'Terkonfirmasi' : 'Ditolak' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal Bukti Pembayaran -->
    <div id="proofModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Bukti Pembayaran</h3>
                <button onclick="closeModal('proofModal')" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <img id="proofImage" src="" alt="Bukti Pembayaran" class="max-h-96 mx-auto rounded-lg">
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="closeModal('proofModal')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@section('ExtraJS')
    <script>
        // Function to show payment proof modal
        function showProof(imageUrl) {
            document.getElementById('proofImage').src = imageUrl;
            document.getElementById('proofModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Function to close modals
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Confirm payment function
        function confirmPayment(form) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: "Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981', // Green
                cancelButtonColor: '#6B7280', // Gray
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        // Reject payment function
        function rejectPayment(form) {
            Swal.fire({
                title: 'Tolak Pembayaran',
                text: "Apakah Anda yakin ingin menolak pembayaran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444', // Red
                cancelButtonColor: '#6B7280', // Gray
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'proofModal') {
                closeModal('proofModal');
            }
        }
    </script>
@endsection
