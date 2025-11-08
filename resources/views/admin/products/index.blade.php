<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Total Orders</h5>
            <p class="fs-4">{{ $totalOrders }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Total Revenue</h5>
            <p class="fs-4">${{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>
</div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openAddModal()">Add Product</button>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->qty }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick='openEditModal(@json($product))'
                                    data-bs-toggle="modal" data-bs-target="#productModal">Edit</button>

                                <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $products->links() }}

                @include('admin.products.modal')
                
            </div>
        </div>
    </div>
</x-app-layout>
