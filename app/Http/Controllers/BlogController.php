<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['posts' => fn ($q) => $q->where('is_active', true)->whereNotNull('published_at')->where('published_at', '<=', now())])
            ->get();

        $categorySlug = $request->query('kategori');
        $activeCategory = null;

        $query = BlogPost::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('blogCategory')
            ->orderByDesc('published_at');

        if ($categorySlug) {
            $activeCategory = BlogCategory::where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $query->where('blog_category_id', $activeCategory->id);
            }
        }

        $posts = $query->paginate(12)->withQueryString();

        return view('blog.index', compact('categories', 'posts', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['blogCategory', 'relatedProducts.categories.segment'])
            ->firstOrFail();

        $relatedPosts = BlogPost::where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $relatedProducts = $post->relatedProducts->isNotEmpty()
            ? $post->relatedProducts->take(3)
            : Product::where('is_active', true)
                ->where('is_featured', true)
                ->with(['categories.segment'])
                ->orderBy('sort_order')
                ->limit(3)
                ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'relatedProducts'));
    }
}
