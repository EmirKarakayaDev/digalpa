<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Segment;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, string $segment)
    {
        $segment = Segment::where('slug', $segment)
            ->where('is_active', true)
            ->firstOrFail();

        $categoryId = $request->query('kategori');

        $categories = Category::where('segment_id', $segment->id)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->get();

        $query = Product::where('is_active', true)
            ->whereHas('categories', fn ($q) => $q->where('segment_id', $segment->id))
            ->orderBy('sort_order');

        if ($categoryId) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
        }

        $products = $query->paginate(24)->withQueryString();

        $activeCategory = $categoryId ? Category::find($categoryId) : null;

        return view('products.index', compact('segment', 'categories', 'products', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['categories.segment'])
            ->firstOrFail();

        $relatedProducts = Product::where('is_active', true)
            ->whereHas('categories', fn ($q) =>
                $q->whereIn('categories.id', $product->categories->pluck('id'))
            )
            ->where('id', '!=', $product->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
