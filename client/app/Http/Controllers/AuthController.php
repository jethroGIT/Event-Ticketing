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

    function logout()
    {
        // Kirim request ke API untuk logout
        $response = Http::post('http://localhost:8000/api/logout');

        // Periksa jika request berhasil
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Logout successful');
        }

        // Handle error
        return redirect()->back()->withErrors(['error' => 'Logout failed']);
    }
}
