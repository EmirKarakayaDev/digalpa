<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finder_nodes', function (Blueprint $table) {
            $table->id();

            // Ağaç yapısı — null ise kök düğüm (Segment seviyesi)
            $table->foreignId('parent_id')->nullable()->constrained('finder_nodes')->cascadeOnDelete();

            // Renk teması için — kök düğümlerde segment bağlı
            $table->foreignId('segment_id')->nullable()->constrained()->nullOnDelete();

            // Seviye: 1=Segment, 2=Uygulama, 3=Detay
            $table->unsignedTinyInteger('depth')->default(1);

            $table->string('label');                    // Kullanıcıya gösterilen seçenek metni
            $table->string('slug');                     // URL state için (segment--uygulama--detay)
            $table->text('description')->nullable();    // İsteğe bağlı yardım metni

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finder_nodes');
    }
};
