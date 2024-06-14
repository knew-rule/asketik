<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::orderBy('created_at', 'desc')->paginate(10); // Fetch orders, latest first, paginate for easier navigation

    return view('ui.admin.order_index', [
        'active' => 'Orders', // Active menu item
        'pageTitle' => 'Orders', // Page title
        'subPageTitle' => 'ESPRESS ONLY FOR YOU',
        'orders' => $orders, // Pass orders data to the view
    ]);
}

    public function getOrderStatus(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);

        return response()->json(['status' => $order->status]);
    }
    
    public function acceptOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);
        $order->status = 'processing'; // Change status to 'processing'
        $order->save();

        return redirect()->back()->with('success', 'Order accepted successfully');
    }

    public function rejectOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);
        $order->status = 'rejected'; // Change status to 'rejected'
        $order->save();

        return redirect()->back()->with('success', 'Order rejected successfully');
    }

    public function pickUpOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);
        $order->status = 'pick up';
        $order->save();

        return redirect()->back()->with('success', 'Order rejected successfully');
    }
    
    public function finishOrder(Request $request)
    {
        $orderId = $request->input('order_id');
    
        $order = Order::findOrFail($orderId);
        $order->status = 'finished'; // Change status to 'finished'
        $order->save();
    
        return response()->json(['success' => true]);
    }
    
    public function store(Request $request)
    {
        \DB::beginTransaction();
    
        try {
            $userId = auth()->id();
            $order = Order::create([
                'user_id' => $userId,
                'order_name' => $request->input('order_name'),
                'order_time' => $request->input('order_time'),
                'note' => $request->input('bill'),
                'subtotal' => $request->input('getSubTotalPrice'),
                'discount' => $request->input('getDiscount'),
                'total' => $request->input('getCheckoutPrice'),
            ]);
    
            foreach ($request->input('cartItems') as $cartItemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'coffee_id' => $cartItemData['coffee_id'],
                    'quantity' => $cartItemData['quantity'],
                    'price' => $cartItemData['price'],
                ]);
            }
    
            $imagePath = null;
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $imagePath = $request->file('image')->store('public/payments');
                // Remove the "public/" prefix from the stored image path for database storage
                $imagePath = str_replace('public/', '', $imagePath);
            }
    
            $order->payment()->create([
                'image' => $imagePath,
            ]);
    
            Cart::where('user_id', auth()->id())->delete();
    
            \DB::commit();
    
            $orderItems = $order->items;
    
            return view('ui.transaction.thankyou', [
                'active' => 'Order',
                'subPageTitle' => 'ESPRESS ONLY FOR YOU',
                'pageTitle' => 'Order Data',
                'order_id' => $order->id,
                'order' => $order,
                'orderItems' => $orderItems,
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['message' => 'Failed to place order', 'error' => $e->getMessage()], 500);
        }
    }
    
}
