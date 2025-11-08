@extends('frontend.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Products</h2>

    <!-- Filter Form -->
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <label for="min_price" class="form-label">Min Price</label>
            <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-4">
            <label for="max_price" class="form-label">Max Price</label>
            <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}>
                <label class="form-check-label" for="in_stock">Only Available</label>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 p-3">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                <p class="card-text">Stock: {{ $product->qty > 0 ? $product->qty : 'Out of stock' }}</p>

                @auth
                    @if($product->qty > 0)
                        <div class="input-group mb-2">
                            <input type="number" name="qty" value="1" min="1" max="{{ $product->qty }}" class="form-control qty-input" data-id="{{ $product->id }}">
                            <button class="btn btn-primary add-to-cart-btn" data-id="{{ $product->id }}">Add to Cart</button>
                        </div>
                    @else
                        <button class="btn btn-secondary mt-2" disabled>Out of stock</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning mt-2">Login to add</a>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No products available.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = "{{ csrf_token() }}";

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;
            const qtyInput = document.querySelector(`.qty-input[data-id="${productId}"]`);
            const qty = parseInt(qtyInput.value) || 1;

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ product_id: productId, qty: qty })
            })
            .then(res => res.json())
            .then(data => {
                // Remove previous message
                const existingMsg = this.parentElement.querySelector('.alert');
                if (existingMsg) existingMsg.remove();

                const message = document.createElement('div');

                if (data.success) {
                    message.classList.add('alert','alert-success','mt-2');
                    message.innerHTML = `${data.message} <a href="{{ route('cart.index') }}" class="btn btn-sm btn-primary ms-2">Go to Cart</a>`;
                } else {
                    message.classList.add('alert','alert-danger','mt-2');
                    message.textContent = data.message || 'Something went wrong!';
                }

                this.parentElement.appendChild(message);
            })
            .catch(err => {
                const existingMsg = this.parentElement.querySelector('.alert');
                if (existingMsg) existingMsg.remove();

                const message = document.createElement('div');
                message.classList.add('alert','alert-danger','mt-2');
                message.textContent = 'Network error. Please try again!';
                this.parentElement.appendChild(message);

                console.error(err);
            });
        });
    });
});

</script>
@endsection
