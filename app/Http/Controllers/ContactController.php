<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:30',
            'company'   => 'nullable|string|max:255',
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string|max:5000',
        ], [
            'full_name.required' => 'Ad soyad zorunludur.',
            'email.required'     => 'E-posta zorunludur.',
            'email.email'        => 'Geçerli bir e-posta adresi giriniz.',
            'subject.required'   => 'Konu zorunludur.',
            'message.required'   => 'Mesaj zorunludur.',
        ]);

        Contact::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Mesajınız iletildi. En kısa sürede dönüş yapacağız.');
    }
}
