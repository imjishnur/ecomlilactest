@extends('frontend.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Order Confirmation</h2>

    <p>Thank you! Your order has been placed successfully.</p>

    <h4>Order #{{ $order->id }}</h4>
    <p>Customer: {{ $order->customer_name }}</p>
  
    <p>Address: {{ $order->customer_address ?? 'N/A' }}</p>
    <p>Status: {{ $order->status == 1 ? 'Pending' : 'Completed' }}</p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end"><strong>Total</strong></td>
                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Continue Shopping</a>
</div>
@endsection
