<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->all();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');

        return view('admin.products.index', compact('products', 'totalOrders', 'totalRevenue'));
    }

    public function create()
    {
       
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
           'description' => 'nullable|string|max:1000',
            'qty'=>'required|integer',
            'price'=>'required|numeric',
            
        ]);

        $this->service->create($data);

        return redirect()->route('admin.products.index')->with('success','Product created successfully!');
    }

    public function edit($id)
    {
        $product = $this->service->find($id);

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'qty'=>'required|integer',
            'price'=>'required|numeric',
        ]);

        $this->service->update($id, $data);

        return redirect()->route('admin.products.index')->with('success','Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.products.index')->with('success','Product deleted successfully!');
    }




}
