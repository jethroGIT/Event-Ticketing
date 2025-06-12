<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input terlebih dahulu
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kirim request ke API
        $response = Http::post('http://localhost:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Periksa jika request berhasil
        if ($response->successful()) {
            return $response->json();
        }

        // Handle error
        return response()->json([
            'error' => 'Login failed',
            'details' => $response->json()
        ], $response->status());
    }
}
