<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = session('token');
        $nama_role = $request->input('search');

        $response = Http::withToken($token)->get('http://localhost:8000/api/roles', [
            'nama_role' => $nama_role
        ]);

        $roles = $response->json();

        if (empty($roles)) {
            return view('roles.index', [
                'roles' => [],
                'search' => $nama_role
            ]);
        }

        return view('roles.index', [
            'roles' => $roles,
            'search' => $nama_role
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/roles', [
            'nama_role' => $request->nama_role
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:8000/api/roles/{$id}", [
            'nama_role' => $request->nama_role
        ]);

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8000/api/roles/{$id}");

        if ($response->failed()) {
            $errorMessage = $response->json('message');
            return back()
                ->withErrors(['api_error' => $errorMessage])
                ->withInput();
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
