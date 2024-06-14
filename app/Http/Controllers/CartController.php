<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coffee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // Common validation rules
    protected function commonValidationRules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('coffee')->get();
        $totalPrice = $cartItems->sum(fn($cartItem) => $cartItem->quantity * $cartItem->coffee->price);
        $pageTitle = 'Cart';
        $subPageTitle = 'FRESH AND ORGANIC';

        return view('ui.transaction.cart', compact('cartItems', 'totalPrice', 'pageTitle', 'subPageTitle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'coffee_id' => 'required|exists:coffees,id',
            'quantity' => 'required|integer|min:1', // Add validation for quantity
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $coffee = Coffee::findOrFail($request->coffee_id);
        $user = auth()->user();
        $quantity = $request->quantity; // Retrieve quantity from request
    
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('coffee_id', $coffee->id)
                        ->first();
    
        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'coffee_id' => $coffee->id,
                'quantity' => $quantity,
            ]);
        }
    
        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully!');
    }

    public function destroy(Cart $cartItem)
    {
        $cartItem->delete();
        $cartItems = auth()->user()->cartItems()->with('coffee')->get();
        return response()->json(['cartItems' => $cartItems]);
    }

    public function update(Request $request, Cart $cartItem)
    {
        $validator = Validator::make($request->all(), $this->commonValidationRules());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => 'Cart item updated successfully']);
    }
}
