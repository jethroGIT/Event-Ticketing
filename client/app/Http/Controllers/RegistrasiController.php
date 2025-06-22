<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $response = Http::get('http://localhost:8000/api/registrasi', [
            'search' => $search
        ]);
        $registrasi = $response->json();
        return view('registrasi.index', ['events' => $registrasi]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function registrasi(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/registrasi', [
            'user_id' => session('user.id')
        ]);

        $event_id = $request->event_id;

        if ($response->successful()) {
            $id = $response->json()['data'];
            return redirect()->route('registrasi.pembayaran', ['id' => $id, 'event_id' => $event_id]);
        } else {
            return back()->with('error', 'Gagal melakukan registrasi');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function konfirmasi($id, $event_id)
    {
        $responseEvent = Http::get("http://localhost:8000/api/registrasi/event/{$event_id}");

        $response = $responseEvent->json()['eventSessions'];
        return view('registrasi.registrasi', [
            'eventSessions' => $response,
            'regis_id' => $id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function storePembayaran(Request $request, $id)
    {
        $validated = $request->validate([
            'sesi_id' => 'required|array|min:1',
            'tipe_pembayaran' => 'required',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $regis_id = $request->input('regis_id');
        $sesi_ids = $request->input('sesi_id');
        $tipe_pembayaran = $request->input('tipe_pembayaran');

        $buktiPembayaran = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaran = base64_encode(file_get_contents($request->file('bukti_pembayaran')->getRealPath()));
        }

        try {
            $response = Http::post('http://localhost:8000/api/registrasi/konfirmasi', [
                'regis_id' => $regis_id,
                'sesi_id' => $sesi_ids,
                'tipe_pembayaran' => $tipe_pembayaran,
                'bukti_pembayaran' => $buktiPembayaran,
            ]);

            if ($response->successful()) {
                return redirect()->route('registrasi.index')->with('success', $response->json('message'));
            } else {
                return back()->with('error', 'Gagal mengirim data ke server.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
