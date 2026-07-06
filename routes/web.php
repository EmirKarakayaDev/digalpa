<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\FinderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Ürünler
Route::get('/urunler/{segment}', [ProductController::class, 'index'])->name('products.index');
Route::get('/urun/{slug}', [ProductController::class, 'show'])->name('products.show');

// Product Finder
Route::get('/urun-bulucu', [FinderController::class, 'index'])->name('finder.index');
Route::get('/urun-bulucu/{slug}', [FinderController::class, 'step'])->name('finder.step');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Referans Projeler
Route::get('/referanslar', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/referanslar/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Hakkımızda
Route::get('/hakkimizda', function () {
    $about = \App\Models\SiteSetting::group('about');
    return view('about', compact('about'));
})->name('about.index');

// İletişim
Route::get('/iletisim', [ContactController::class, 'index'])->name('contact.index');
Route::post('/iletisim', [ContactController::class, 'store'])->name('contact.store');

// Doküman talebi (modal POST)
Route::post('/dokuman-talep', [DocumentRequestController::class, 'store'])->name('document-request.store');
