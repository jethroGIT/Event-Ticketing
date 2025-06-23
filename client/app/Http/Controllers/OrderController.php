<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user_id = session('user.id');
        $response = Http::get('http://localhost:8000/api/orders', [
            'user_id' => $user_id
        ]);
        $orders = $response->json();
        return view('orders.index', ['orders' => $orders]);
    }

    public function cancel ($order_id) {
        $response = Http::delete("http://localhost:8000/api/orders/{$order_id}");
        
        if ($response->successful()) {
            return redirect()->route('orders.index')->with('success', $response->json()['message']);
        } else {
            return redirect()->route('orders.index')->with('error', 'Failed to delete order.');
        }
    }
}
