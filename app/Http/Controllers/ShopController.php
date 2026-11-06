<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'latest');
        $query = match($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = [
            'sneakers' => 'Sneakers & Streetwear',
            'formal' => 'Sepatu Formal',
            'sandal' => 'Sandal Kasual',
            'perawatan' => 'Produk Perawatan',
        ];

        $brands = Product::active()
            ->whereNotNull('brand')
            ->select('brand')
            ->distinct()
            ->pluck('brand');

        return view('shop.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
