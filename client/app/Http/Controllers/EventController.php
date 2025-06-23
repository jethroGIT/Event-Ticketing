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
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'start_event' => 'required|date',
            'end_event' => 'required|date|after_or_equal:start_event',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
            'biaya_registrasi' => 'nullable|numeric|min:0',
            'maks_peserta' => 'nullable|integer|min:1'
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $originalName = $file->getClientOriginalName();
            $posterPath = $file->storeAs('posters', $originalName, 'public');
        }

        $response = Http::post('http://localhost:8000/api/events', [
            'nama_event' => $request->nama_event,
            'start_event' => $request->start_event,
            'end_event' => $request->end_event,
            'lokasi' => $request->lokasi,
            'narasumber' => $request->narasumber,
            'poster_url' => $posterPath ? Storage::url($posterPath) : null,
            'deskripsi' => $request->deskripsi,
            'biaya_registrasi' => $request->biaya_registrasi,
            'maks_peserta' => $request->maks_peserta,
            'created_by' => session('user.id'),
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
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'start_event' => 'required|date',
            'end_event' => 'required|date|after_or_equal:start_event',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'poster' => 'nullable|image|max:2048', // max 2MB
            'deskripsi' => 'nullable|string',
            'biaya_registrasi' => 'nullable|numeric',
            'maks_peserta' => 'nullable|integer'
        ]);

        $posterData = [];

        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($request->poster_url_lama) {
                $oldFilename = basename($request->poster_url_lama);
                Storage::delete('public/posters/' . $oldFilename);
            }

            // Simpan poster baru
            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/posters', $filename);

            // Generate URL yang benar
            $posterData['poster_url'] = asset('storage/posters/' . $filename);
        } else {
            $posterData['poster_url'] = $request->poster_url_lama;
        }

        $data = [
            'nama_event' => $request->nama_event,
            'start_event' => $request->start_event,
            'end_event' => $request->end_event,
            'lokasi' => $request->lokasi,
            'narasumber' => $request->narasumber,
            'deskripsi' => $request->deskripsi,
            'biaya_registrasi' => $request->biaya_registrasi,
            'maks_peserta' => $request->maks_peserta,
            'created_by' => session('user.id')
        ];

        // Gabungkan data poster jika ada
        $data = array_merge($data, $posterData);

        $response = Http::put("http://localhost:8000/api/events/{$id}", $data);

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
