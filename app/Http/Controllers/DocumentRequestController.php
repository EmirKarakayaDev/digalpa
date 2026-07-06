<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'nullable|exists:products,id',
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:30',
            'company'       => 'nullable|string|max:255',
            'document_type' => 'required|in:tds,sds,both',
            'message'       => 'nullable|string|max:2000',
        ], [
            'full_name.required'     => 'Ad soyad zorunludur.',
            'email.required'         => 'E-posta zorunludur.',
            'email.email'            => 'Geçerli bir e-posta adresi giriniz.',
            'document_type.required' => 'Doküman türü seçiniz.',
            'document_type.in'       => 'Geçersiz doküman türü.',
        ]);

        DocumentRequest::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('document_request_success', 'Talebiniz alındı. Doküman en kısa sürede e-posta adresinize iletilecektir.');
    }
}
