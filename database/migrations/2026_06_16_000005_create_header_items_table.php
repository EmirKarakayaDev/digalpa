<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('header_items')->nullOnDelete();
            $table->string('label');
            $table->string('url')->nullable();          // Boşsa mega menü tetikleyici
            $table->enum('type', ['link', 'mega_menu', 'button'])->default('link');
            $table->string('target')->default('_self'); // _self | _blank
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_items');
    }
};
