@extends('layout.layout')
@section('title', 'Tambah Event')

@section('content')
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Tambah Event</h2>
        <form action="{{ route('events.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <!-- Nama Event -->
            <div>
                <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event:</label>
                <input type="text" id="nama_event" name="nama_event" value="{{ old('nama_event') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Start Event -->
            <div>
                <label for="start_event" class="block text-sm font-medium text-gray-700">Tanggal Mulai:</label>
                <input type="date" id="start_event" name="start_event" value="{{ old('start_event') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- End Event -->
            <div>
                <label for="end_event" class="block text-sm font-medium text-gray-700">Tanggal Selesai:</label>
                <input type="date" id="end_event" name="end_event" value="{{ old('end_event') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi:</label>
                <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Narasumber -->
            <div>
                <label for="narasumber" class="block text-sm font-medium text-gray-700">Narasumber:</label>
                <input type="text" id="narasumber" name="narasumber" value="{{ old('narasumber') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Poster - Input File Bawaan HTML -->
            <div>
                <label for="poster" class="block text-sm font-medium text-gray-700">Poster Event:</label>
                <input type="file" id="poster" name="poster" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG (Maks. 2MB)</p>
                @error('poster')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi:</label>
                <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Biaya -->
            <div>
                <label for="biaya_registrasi" class="block text-sm font-medium text-gray-700">Biaya Registrasi:</label>
                <input type="number" id="biaya_registrasi" name="biaya_registrasi" value="{{ old('biaya_registrasi') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Maksimal Peserta -->
            <div>
                <label for="maks_peserta" class="block text-sm font-medium text-gray-700">Maksimal Peserta:</label>
                <input type="number" id="maks_peserta" name="maks_peserta" value="{{ old('maks_peserta') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('events.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md">Kembali</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('poster').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
            console.log('File dipilih:', fileName);
        });
    </script>
@endsection
