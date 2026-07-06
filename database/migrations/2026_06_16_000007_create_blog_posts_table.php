<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();       // Listede görünen özet
            $table->longText('content')->nullable();   // Rich text içerik
            $table->string('image')->nullable();       // Öne çıkan görsel
            $table->string('author')->nullable();      // Yazar adı (serbest metin)

            // Yayınlama kontrolü
            $table->timestamp('published_at')->nullable(); // null = taslak
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
