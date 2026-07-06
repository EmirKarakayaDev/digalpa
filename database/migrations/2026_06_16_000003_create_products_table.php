<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();  // Kart özeti
            $table->longText('description')->nullable();    // Tam açıklama (rich text)

            // Teknik özellikler — ürüne göre değiştiği için JSON (accordion)
            $table->json('technical_specs')->nullable();    // [{"label":"...", "value":"..."}]
            $table->json('package_sizes')->nullable();      // ["5 kg", "20 kg", "200 kg"]

            // Hesaplayıcı (Brief §06: ürün sayfası sticky sidebar)
            $table->decimal('coverage_min', 8, 2)->nullable(); // m²/kg minimum
            $table->decimal('coverage_max', 8, 2)->nullable(); // m²/kg maximum
            $table->string('coverage_unit')->default('m²/kg');

            // Dokümanlar
            $table->string('tds_file')->nullable();  // Technical Data Sheet
            $table->string('sds_file')->nullable();  // Safety Data Sheet

            // Görseller
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();     // ["path1.jpg", "path2.jpg"]

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
