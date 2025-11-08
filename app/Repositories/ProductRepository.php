<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
public function allActive()
{
    $query = Product::query();

    if ($min = request('min_price')) {
        $query->where('price', '>=', $min);
    }

    if ($max = request('max_price')) {
        $query->where('price', '<=', $max);
    }

    if (request('in_stock')) {
        $query->where('qty', '>', 0);
    }

    return $query->latest()->paginate(10)->withQueryString();
}


    public function all()
    {
        return Product::latest()
            ->paginate(10);
    }

    public function find(int $id): ?Product
    {
        return Product::withTrashed()->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        return $product->delete();
    }
}
