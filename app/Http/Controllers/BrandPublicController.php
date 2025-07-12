<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Routing\Controller; // Pastikan ini diimpor jika belum ada

class BrandPublicController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', 1)->get();
        return view('brands.index', compact('brands'));
    }

    /**
     * Menampilkan detail brand dan produk aktif terkait.
     * Menggunakan Route Model Binding untuk mendapatkan instance Brand.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\View\View
     */
   public function show(Brand $brand)
{
    $query = Product::where('brand_id', $brand->id)->where('is_active', 1);

    if ($category = request('category')) {
        $query->whereHas('category', function ($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    $products = $query->get();

    return view('brands.show', compact('brand', 'products'));
}

}
