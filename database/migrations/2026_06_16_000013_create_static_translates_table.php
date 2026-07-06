<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_translates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // Blade'de kullanılan anahtar: "nav.products"
            $table->string('locale', 5)->default('tr'); // tr | en
            $table->text('value');                  // Gösterilen metin
            $table->string('group')->nullable();    // Gruplama: nav, footer, product, finder...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_translates');
    }
};
