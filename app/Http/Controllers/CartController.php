<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('cartItems')->get();
        return response()->json(['carts' => $carts], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($request->all());

        return response()->json(['cart' => $cart], 201);
    }

    public function show($id)
    {
        $cart = Cart::with('cartItems')->findOrFail($id);
        return response()->json(['cart' => $cart], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'exists:users,id',
        ]);

        $cart = Cart::findOrFail($id);
        $cart->update($request->all());

        return response()->json(['cart' => $cart], 200);
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully'], 200);
    }
}
