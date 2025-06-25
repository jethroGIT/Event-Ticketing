<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class KehadiranController extends Controller
{
    public function index()
    {
        $role = session('user.role');
        if ($role == 1 || $role == 3) {
            return view('kehadiran.scan');
        } else {
            return redirect()->back()->withErrors(['error' => 'Akses tidak diizinkan']);
        }
    }

    public function proxy(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/validasi-qr', [
            'qr_token' => $request->qr_token
        ]);

        return response($response->json(), $response->status());
    }

    public function sertifikatKehadiran(Request $request)
    {
        $user = session('user.id');
        $role = session('user.role');
        $response = Http::get('http://localhost:8000/api/kehadiran', [
            'user_id' => $user,
            'role' => $role,

        ]);

        if ($response->successful()) {
            $data = $response->json();

            if ($role == 1 || $role == 3) {
                return view('kehadiran.sertifikat', [
                    'data' => $data,
                ]);
            } elseif ($role == 2) {
                return view('kehadiran.sertifikat-member', [
                    'data' => $data,
                ]);
            }
        } else {
            if ($role == 1 || $role == 3) {
                return view('kehadiran.sertifikat');
            } elseif ($role == 2) {
                return view('kehadiran.sertifikat-member');
            }
        }
    }

    public function uplodSertifikat(Request $request, $id)
    {
        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('sertifikat');
        $originalName = time() . '_' . $file->getClientOriginalName();
        $sertifPath = $file->storeAs('public/sertifikat', $originalName);
        $sertifikatUrl = asset('storage/sertifikat/' . $originalName);

        $response = Http::put("http://localhost:8000/api/kehadiran/{$id}", [
            'sertifikat_url' => $sertifikatUrl
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Sertifikat berhasil diunggah');
        } else {
            return redirect()->back()->withErrors(['error' => 'Gagal mengunggah sertifikat']);
        }
    }
}
