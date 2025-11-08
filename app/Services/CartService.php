<?php

namespace App\Services;
use App\Events\OrderPlaced;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function add(int $productId, int $qty = 1): array
    {
        $product = Product::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        if ($qty > $product->qty) {
            return [
                'success' => false,
                'message' => "Cannot add more than available stock for {$product->name} (Available: {$product->qty})"
            ];
        }

        $userId = Auth::id();

        $cartItem = Cart::firstOrNew([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + $qty;
        $cartItem->save();

        return [
            'success' => true,
            'message' => "{$product->name} quantity updated in cart",
            'qty' => $cartItem->quantity
        ];
    }

    public function remove(int $productId): array
    {
        Cart::where('user_id', Auth::id())->where('product_id', $productId)->delete();

        return ['success' => true, 'message' => 'Product removed from cart'];
    }

    public function getItems(): array
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $items = [];
        foreach ($cartItems as $cart) {
            if (!$cart->product) continue;

            $items[] = [
                'product' => $cart->product,
                'qty' => $cart->quantity,
                'total' => $cart->product->price * $cart->quantity,
            ];
        }

        return $items;
    }

    public function getTotal(): float
    {
        return collect($this->getItems())->sum('total');
    }

    public function clear(): void
    {
        Cart::where('user_id', Auth::id())->delete();
    }

    public function checkStock(): array
    {
        foreach ($this->getItems() as $item) {
            if ($item['product']->qty < $item['qty']) {
                return [
                    'success' => false,
                    'message' => "Not enough stock for {$item['product']->name} (Available: {$item['product']->qty})"
                ];
            }
        }

        return ['success' => true];
    }

    public function checkout(): array
{
    $items = $this->getItems();
    if (empty($items)) {
        return ['success' => false, 'message' => 'Cart is empty'];
    }

    $stockCheck = $this->checkStock();
    if (!$stockCheck['success']) {
        return $stockCheck;
    }

    $total = $this->getTotal();
    $user = Auth::user(); 

    $order = Order::create([
        'user_id' => Auth::id(),  
        'customer_name' => $user ? $user->name : 'Guest',
        'customer_email' => $user ? $user->email : null,
        'total' => $total,
        'status' => 1,
    ]);

    $orderItems = [];

    foreach ($items as $item) {
        $item['product']->decrement('qty', $item['qty']);

        $orderItem = $order->items()->create([
            'product_id' => $item['product']->id,
            'product_name' => $item['product']->name,
            'quantity' => $item['qty'],
            'price' => $item['product']->price,
            'total' => $item['total'],
        ]);

        $orderItems[] = $orderItem;
    }
    event(new OrderPlaced($order));
    $this->clear();

    return [
        'success' => true,
        'message' => 'Checkout successful',
        'order_id' => $order->id,
        'order' => [
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'total' => $order->total,
            'status' => $order->status,
            'items' => $orderItems
        ]
    ];
}

}
