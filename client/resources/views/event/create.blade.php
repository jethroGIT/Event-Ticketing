@extends('layout.layout')
@section('title', 'Tambah User')

@section('content')
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Tambah Event</h2>
        <form action="{{ route('events.store') }}" method="POST" class="space-y-4">
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

            <!-- Poster -->
            <div>
                <label for="poster_url" class="block text-sm font-medium text-gray-700">Poster:</label>
                <input type="text" id="poster_url" name="poster_url" value="{{ old('poster_url') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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

            <div class="flex justify-between mt-6">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection