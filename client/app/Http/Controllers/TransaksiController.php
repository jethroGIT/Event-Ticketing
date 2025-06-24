<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user_id = session('user.id');
        $role = session('user.role');
        $response = Http::get('http://localhost:8000/api/orders-ticket', [
            'user_id' => $user_id,
            'role' => $role,
        ]);
        $orders = $response->json();
        return view('transaksi.index', ['orders' => $orders]);
    }

    public function cancel ($id) {
        $response = Http::delete("http://localhost:8000/api/orders-ticket/{$id}");
        
        if ($response->successful()) {
            return redirect()->route('tickets.index')->with('success', $response->json()['message']);
        } else {
            return redirect()->route('tickets.index')->with('error', 'Failed to delete order.');
        }
    }

    public function logPembayaran() {
        $response = Http::get('http://localhost:8000/api/orders');

        if ($response->successful()) {
            $orders = $response->json();
            return view('transaksi.logPembayaran', ['orders' => $orders]);
        } else {
            return redirect()->route('tickets.index')->with('error', 'Failed to retrieve orders.');
        }
    }

    public function updateLog(Request $request, $id) {
        $status_pembayaran = $request->input('status_pembayaran');

        $response = Http::put("http://localhost:8000/api/orders/{$id}", [
            'status_pembayaran' => $status_pembayaran,
        ]);

        if ($response->successful()) {
            return redirect()->route(('orders.index'))->with('success', $response->json('message'));
        } else {
            return redirect()->route('orders.index')->with('error', 'Failed to retrieve order details.');
        }
    } 
}
