<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
       
    }

    /**
     * List all active products
     */
    public function index(Request $request)
    {
        $products = $this->service->getActive();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
