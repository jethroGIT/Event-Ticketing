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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('http://localhost:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $data = $response->json();

        if (isset($data['token'])) {
            session([
                'token' => $data['token'],
                'user' => $data['data'],
            ]);

            return redirect()->route('registrasi.index')->with('success', $response->json()['message']);
        }
        
        return redirect()->back()->withErrors(['errors' => $data['message']]);
    }

    public function signup(Request $request) {
        return view('auth.signup');
    }

    public function signupStore(Request $request) {
        $response = Http::post('http://localhost:8000/api/users', [
            'role_id' => 2,
            'email' => $request->email,
            'password' => $request->password,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'status' => 'Aktif',
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('login')->with('success', 'User berhasil dibuat!');
    }

    public function logout()
    {
        session()->forget(['token', 'user']);
        return redirect('/login');

        return redirect()->back()->withErrors(['error' => 'Logout failed']);
    }
}
