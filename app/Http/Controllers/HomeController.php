<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 produk terbaru
        $products = Product::latest()->take(3)->get();

        return view('home', compact('products'));
    }
}
