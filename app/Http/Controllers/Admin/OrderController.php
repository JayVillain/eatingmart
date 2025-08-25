<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        $user = auth()->user();
        $virtualAccount = 'VA' . Str::random(10) . rand(1000, 9999);
        $totalPrice = 0;
        foreach ($request->items as $item) {
            $menu = \App\Models\Menu::find($item['menu_id']);
            $totalPrice += $menu->price * $item['quantity'];
        }
        $order = $user->orders()->create([
            'total_price' => $totalPrice,
            'status' => 'pending_payment',
            'virtual_account_number' => $virtualAccount,
        ]);
        foreach ($request->items as $item) {
            $menu = \App\Models\Menu::find($item['menu_id']);
            $order->items()->create([
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
            ]);
        }
        return response()->json(['message' => 'Pesanan berhasil dibuat. Menunggu pembayaran.', 'order' => $order], 201);
    }
    public function index()
    {
        $orders = Order::with('user', 'items.menu')->latest()->get();
        return response()->json($orders);
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:paid,completed,cancelled']);
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => 'Status pesanan berhasil diperbarui.', 'order' => $order]);
    }
}