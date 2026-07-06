<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use App\Models\ReferenceProject;
use App\Models\Segment;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $segments = Segment::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->with('categories.segment')
            ->get();

        $featuredProjects = ReferenceProject::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->with('segment')
            ->get();

        $latestPosts = BlogPost::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->limit(3)
            ->with('blogCategory')
            ->get();

        $home  = SiteSetting::group('home');
        $akemi = SiteSetting::group('akemi');

        return view('home', compact('segments', 'featuredProducts', 'featuredProjects', 'latestPosts', 'home', 'akemi'));
    }
}
