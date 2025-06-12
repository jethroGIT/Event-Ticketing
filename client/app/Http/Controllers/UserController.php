<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $response = Http::get('http://localhost:8000/api/users', [
            'email' => $search
        ]);

        $users = $response->json();

        if (empty($users)) {
            return view('users.index', [
                'users' => [],
                'search' => $search
            ]);
        }

        return view('users.index', [
            'users' => $users,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/users', [
            'role_id' => $request->role_id,
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

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get("http://localhost:8000/api/users/{$id}");
        $user = (object)$response['data'];

        return view('users.show', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:8000/api/users/{$id}", [
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => $request->password,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'status' => $request->status,
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8000/api/users/{$id}");

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage]);
        }
        
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
