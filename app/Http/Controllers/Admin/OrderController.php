<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders');
    }

    public function list()
    {
        $orders = Order::with('user', 'items.menu')->latest()->get();
        return response()->json($orders);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:paid,completed,cancelled',
        ]);
        
        $order->status = $request->status;
        $order->save();
        
        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui.',
            'order' => $order,
        ]);
    }
}