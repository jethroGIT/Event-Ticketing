<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = session('token');
        $search = $request->input('search');

        $response = Http::withToken($token)->get('http://localhost:8000/api/events', [
            'nama_event' => $search
        ]);

        $events = $response->json();

        if (empty($events)) {
            return view('event.index', [
                'events' => [],
                'search' => $search
            ]);
        }

        return view('event.index', [
            'events' => $events,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/events', [
            'nama_event' => $request->nama_event,
            'start_event' => $request->start_event,
            'end_event' => $request->end_event,
            'lokasi' => $request->lokasi,
            'narasumber' => $request->narasumber,
            'poster_url' => $request->poster_url, // ? Storage::url($request->poster_url) : null,
            'deskripsi' => $request->deskripsi,
            'biaya_registrasi' => $request->biaya_registrasi,
            'maks_peserta' => $request->maks_peserta,
            'created_by' => session('user.id')
,
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get("http://localhost:8000/api/events/{$id}");
        $events = (object)$response['data'];

        return view('event.show', compact('events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:8000/api/events/{$id}", [
            'nama_event' => $request->nama_event,
            'start_event' => $request->start_event,
            'end_event' => $request->end_event,
            'lokasi' => $request->lokasi,
            'narasumber' => $request->narasumber,
            'poster_url' => $request->poster_url, // ? Storage::url($request->poster_url) : null,
            'deskripsi' => $request->deskripsi,
            'biaya_registrasi' => $request->biaya_registrasi,
            'maks_peserta' => $request->maks_peserta,
            'created_by' => 1 //Auth::user()->id,
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8000/api/events/{$id}");

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage]);
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }
}
