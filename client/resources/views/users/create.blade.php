@extends('layout.layout')
@section('title', 'Tambah User')

@section('content')
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Tambah User</h2>
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Role Selection -->
            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role:</label>
                <select id="role_id" name="role_id" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Role</option>
                    <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Member</option>
                    <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Panitia</option>
                    <option value="4" {{ old('role_id') == '4' ? 'selected' : '' }}>Keuangan</option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Minimal 6 karakter</p>
            </div>

            <!-- Name -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Address -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="no_tlp" class="block text-sm font-medium text-gray-700">Nomor Telepon:</label>
                <input type="tel" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection