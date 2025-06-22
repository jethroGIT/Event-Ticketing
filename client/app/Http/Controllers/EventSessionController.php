<?php

namespace App\Http\Controllers;

use session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $token = session('token');
        $response = Http::withToken($token)->get("http://localhost:8000/api/events/{$id}/sessions");

        if ($response->successful()) {
            $sessions = $response->json();
            return view('event-session.index', compact('sessions', 'id'));
        } else {
            $errorMessage = $response->json('message');
            return view('event-session.index', compact('id'))->with(['api_error' => $errorMessage]);
        }   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $token = session('token');
        $response = Http::withToken($token)->post("http://localhost:8000/api/events/{$id}/sessions", [
            'nama_sesi' => $request->nama_sesi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        if ($response->successful()) {
            return redirect()->route('sessions.index', ['id' => $id])->with('success', 'Sesi berhasil ditambahkan.');
        } else {
            $errorMessage = $response->json('message');
            return redirect()->back()->withErrors(['api_error' => $errorMessage]);
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $token = session('token');
        $response = Http::withToken($token)->put("http://localhost:8000/api/events/sessions/{$id}", [
            'nama_sesi' => $request->nama_sesi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Sesi berhasil diperbarui.');
        } else {
            $errorMessage = $response->json('message');
            return redirect()->back()->withErrors(['api_error' => $errorMessage]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $token = session('token');
        $response = Http::withToken($token)->delete("http://localhost:8000/api/events/sessions/{$id}");

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Sesi berhasil dihapus.');
        } else {
            $errorMessage = $response->json('message');
            return redirect()->back()->withErrors(['api_error' => $errorMessage]);
        }
    }
}
