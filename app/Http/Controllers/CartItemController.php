<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::all();
        return response()->json(['cart_items' => $cartItems], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cart_id' => 'required|exists:carts,id',
            'room_id' => 'required|exists:rooms,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::create($request->all());

        return response()->json(['cart_item' => $cartItem], 201);
    }

    public function show($id)
    {
        $cartItem = CartItem::findOrFail($id);
        return response()->json(['cart_item' => $cartItem], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cart_id' => 'exists:carts,id',
            'room_id' => 'exists:rooms,id',
            'quantity' => 'integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($request->all());

        return response()->json(['cart_item' => $cartItem], 200);
    }

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Cart item deleted successfully'], 200);
    }
}
