<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * (a) Mendapatkan daftar produk (Products API).
     */
    public function index()
    {

        $products = Product::where('stock', '>', 0)
                            ->orderBy('title', 'asc')
                            ->paginate(15); 
                            
        if ($products->isEmpty() && $products->currentPage() == 1) {
             return response()->json([
                'status' => 'success',
                'message' => 'No products found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products list retrieved successfully.',
            'data' => $products
        ], 200);
    }

    /**
     * (b) Mendapatkan detail produk (Detail Product API).
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->where('stock', '>', 0)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found or out of stock.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product details retrieved successfully.',
            'data' => $product
        ], 200);
    }
}