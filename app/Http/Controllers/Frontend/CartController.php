<?php

namespace App\Http\Controllers\Frontend;

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
        $cartItems = $this->cart->getItems();
        $total = $this->cart->getTotal();

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
       $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $qty = $request->input('qty');

        $response = $this->cart->add($productId, $qty);

        return response()->json($response);
    }

    public function remove(int $id)
    {
        $this->cart->remove($id);
        return response()->json(['success' => true, 'message' => 'Product removed from cart']);
    }

    public function checkout()
    {
        $result = $this->cart->checkout(); 

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'order_id' => $result['order_id'] ?? null
        ]);
    }

    public function orderSuccess($orderId)
    {
        $order = \App\Models\Order::with('items.product')->findOrFail($orderId);

        return view('frontend.order.success', compact('order'));
    }
}
