<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductCategory;
use App\Models\Product;

class MenuController extends Controller
{
    
    
    public function categories()
    {
        $menus = ProductCategory::query()->active()->get();
        return response()->json($menus, 200);
    }

    public function menuProduct(Request $request)
    {
        $products = Product::with(['category','shop'])->get();
        return response()->json($products, 200);
    }

    public function popularProducts(Request $request)
    {
        $products = Product::with(['category','shop'])->get();
        return response()->json($products, 200);
    }
}
