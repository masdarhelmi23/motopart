<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductPublicController extends Controller
{
    public function show(Product $product)
    {
        return view('produk.show', compact('product'));
    }
}
