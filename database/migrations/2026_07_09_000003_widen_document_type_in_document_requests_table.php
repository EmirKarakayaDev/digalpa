<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // document_type artık tekli enum ('tds'|'sds'|'both') değil, çoklu
        // seçim destekleyen virgülle ayrılmış bir liste ("tds,sds,ce" gibi)
        // — CE eklenince "both" gibi sabit kombinasyonlar yetersiz kaldı
        // (Brief §05: "TDS + SDS + CE"). doctrine/dbal'e bağımlı kalmamak
        // için ham ALTER TABLE kullanıldı. SQLite'da MODIFY yok, kolon zaten
        // esnek (dynamic typing) olduğundan orada bu adıma gerek yok.
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE document_requests MODIFY document_type VARCHAR(30) NOT NULL DEFAULT 'tds'");
        }

        // Var olan 'both' kayıtlarını yeni formata taşı
        DB::table('document_requests')->where('document_type', 'both')->update(['document_type' => 'tds,sds']);
    }

    public function down(): void
    {
        DB::table('document_requests')->where('document_type', 'tds,sds')->update(['document_type' => 'both']);
        DB::statement("ALTER TABLE document_requests MODIFY document_type ENUM('tds','sds','both') NOT NULL DEFAULT 'tds'");
    }
};
