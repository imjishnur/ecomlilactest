@extends('frontend.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Shopping Cart</h2>

    @if(count($cartItems) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item['product']->name }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>${{ number_format($item['product']->price,2) }}</td>
                <td>${{ number_format($item['total'],2) }}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-cart-btn" data-id="{{ $item['product']->id }}">Remove</button>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end"><strong>Total</strong></td>
                <td colspan="2" id="cart-total">${{ number_format($total,2) }}</td>
            </tr>
        </tbody>
    </table>

    <button id="checkout-btn" class="btn btn-primary">Checkout</button>

    @else
    <p>Cart is empty.</p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    document.querySelectorAll('.remove-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;

            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if(data.success){
                      location.reload();
                  }
              });
        });
    });

    document.getElementById('checkout-btn')?.addEventListener('click', function () {
        fetch('/cart/checkout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                window.location.href = `/order-success/${data.order_id}`;
            } else {
                alert(data.message);
            }
        });
    });

});
</script>
@endsection
