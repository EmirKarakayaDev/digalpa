<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // CE Uygunluk Belgesi (Brief §05: "TDS + SDS + CE")
            $table->string('ce_file')->nullable()->after('sds_file');

            // Uygulama adımları — accordion'da ayrı, kapalı başlayan bölüm
            // (Brief §05 accordion sırası, madde 3)
            $table->json('application_steps')->nullable()->after('package_sizes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ce_file', 'application_steps']);
        });
    }
};
