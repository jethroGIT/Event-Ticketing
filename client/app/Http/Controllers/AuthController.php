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

            return redirect()->route('dashboard')->with('success', $response->json()['message']);
        }
        
        return redirect()->back()->withErrors(['errors' => $data['message']]);
    }

    public function logout()
    {
        session()->forget(['token', 'user']);
        return redirect('/login');

        return redirect()->back()->withErrors(['error' => 'Logout failed']);
    }
}
