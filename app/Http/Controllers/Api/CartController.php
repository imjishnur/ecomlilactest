<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'items' => $this->cart->getItems(),
            'total' => $this->cart->getTotal(),
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $response = $this->cart->add($request->product_id, $request->qty);

        return response()->json($response);
    }

    public function remove(int $id)
    {
        $this->cart->remove($id);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'items' => $this->cart->getItems(),
            'total' => $this->cart->getTotal(),
        ]);
    }

    public function checkout()
    {
        $result = $this->cart->checkout();

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 400);
        }

        // Return full order details
        $order = \App\Models\Order::with('items.product')->find($result['order_id']);

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'order' => $order,
        ]);
    }
}
