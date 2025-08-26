<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Method untuk admin panel (web)
    public function index()
    {
        return view('admin.orders'); // Perbaikan: Langsung mengarah ke 'orders.blade.php'
    }

    public function list()
    {
        $orders = Order::with(['user', 'items.menu'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,paid,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status pesanan berhasil diupdate',
            'order' => $order->load(['user', 'items.menu'])
        ]);
    }

    // Method untuk API customer
    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.menu_id' => 'required|exists:menus,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            $totalAmount = 0;
            $orderItems = [];
            $virtualAccount = 'VA' . Str::random(10) . rand(1000, 9999);

            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $itemTotal = $menu->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'virtual_account_number' => $virtualAccount,
                'total_price' => $totalAmount,
                'status' => 'pending_payment',
            ]);

            $order->items()->createMany($orderItems);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil!',
                'data' => [
                    'order' => $order->load(['items.menu']),
                    'total_price' => $totalAmount,
                    'virtual_account_number' => $order->virtual_account_number
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat checkout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function customerOrders(Request $request)
    {
        $orders = Order::with(['items.menu'])
                       ->where('user_id', $request->user()->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}