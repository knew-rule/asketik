<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $cartItems = Cart::all();
        $couponCode = $request->input('coupon_code');

        if (empty($couponCode)) {
            return response()->json(['error' => 'Coupon code is required.'], 422);
        }

        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.'], 422);
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = $this->calculateDiscount($coupon, $subtotal);
        $totalPrice = $subtotal - $discount;

        return response()->json([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'totalPrice' => $totalPrice,
            'success' => 'Coupon applied successfully.'
        ]);
    }

    public function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->coffee->price;
        });
    }

    public function calculateDiscount($coupon, $subtotal)
    {
        $discount = 0;
    
        if ($coupon->type === 'percentage') {
            $discount = ($coupon->value / 100) * $subtotal;
        } elseif ($coupon->type === 'fixed_amount') {
            $discount = $coupon->value;
        }
    
        return $discount;
    }

    public function index()
    {
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric',
            'max_uses' => 'nullable|integer',
            'expiry_date' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('coupons')->ignore($coupon->id),
            ],
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric',
            'max_uses' => 'nullable|integer',
            'expiry_date' => 'nullable|date',
        ]);

        $coupon->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
