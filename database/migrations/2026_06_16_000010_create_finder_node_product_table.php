<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finder_node_product', function (Blueprint $table) {
            $table->foreignId('finder_node_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->primary(['finder_node_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finder_node_product');
    }
};
