<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ürün sayfasındaki "İlgili Projeler" accordion'u için (Brief §05
        // accordion sırası, madde 5). used_products alanı serbest metin
        // olduğundan ürün sayfasından projelere geri link vermiyordu — bu
        // pivot, product -> reference_project yönünde gerçek bir ilişki kurar.
        Schema::create('product_reference_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reference_project_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'reference_project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reference_project');
    }
};
