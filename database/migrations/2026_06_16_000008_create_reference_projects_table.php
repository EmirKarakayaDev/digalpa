<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('segment_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client')->nullable();       // Müşteri / yapı adı
            $table->string('location')->nullable();     // Şehir veya konum
            $table->unsignedSmallInteger('year')->nullable();
            $table->text('description')->nullable();   // Kısa özet (listede)
            $table->longText('content')->nullable();   // Detay sayfası içeriği

            // Kullanılan ürünler (serbest metin, pivot kurmaya gerek yok)
            $table->json('used_products')->nullable(); // ["Ürün A", "Ürün B"]

            // Görseller
            $table->string('image')->nullable();       // Kapak görseli
            $table->json('gallery')->nullable();       // Galeri

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // Ana sayfada göster
            $table->unsignedSmallInteger('sort_order')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_projects');
    }
};
