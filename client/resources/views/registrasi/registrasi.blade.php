@extends('layout.layout')
@section('title', 'Registrasi Event')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-indigo-800">Registrasi Event</h1>
        <p class="text-gray-600">Pilih sesi dan konfirmasi pembayaran</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <!-- FORM KONFIRMASI -->
        <form id="main-form" action="{{ route('registrasi.store', ['id' => $regis_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="regis_id" value="{{ $regis_id }}">

            <!-- Sesi Event Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-indigo-800 mb-4">Pilih Sesi Event</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($eventSessions as $sesi)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="sesi_id[]" value="{{ $sesi['id'] }}"
                                    class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $sesi['nama_sesi'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <svg class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $sesi['tanggal'] }} |
                                        <svg class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $sesi['jam_mulai'] }} - {{ $sesi['jam_selesai'] }}
                                    </p>
                                    <p class="text-sm text-gray-800 mt-2">
                                        <span class="font-medium">Event:</span> {{ $sesi['Events']['nama_event'] }}
                                    </p>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Pembayaran Section -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-indigo-800 mb-4">Konfirmasi Pembayaran</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tipe_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pembayaran</label>
                        <select name="tipe_pembayaran" id="tipe_pembayaran"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                            <option value="cod">Cash on Delivery</option>
                        </select>
                    </div>

                    <div>
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Hanya tombol Konfirmasi disini -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Konfirmasi Pembayaran
                </button>
            </div>
        </form>

        <!-- FORM BATAL (DI LUAR FORM UTAMA) -->
        <div class="flex justify-end mt-4">
            <form id="delete-form-{{ $regis_id }}" action="{{ route('registrasi.destroy', ['id' => $regis_id]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDelete({{ $regis_id }})"
                    class="bg-red-100 hover:bg-red-200 text-red-600 font-medium py-2 px-6 rounded-lg transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('ExtraJS')
<script>
    function confirmDelete(regisId) {
        Swal.fire({
            title: 'Batalkan Registrasi?',
            text: "Semua data konfirmasi akan dihapus!",
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
                document.getElementById('delete-form-' + regisId).submit();
            }
        });
    }
</script>
@endsection
