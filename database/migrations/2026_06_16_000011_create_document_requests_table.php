<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Talep eden kişi bilgileri
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();

            // Hangi dokümanlar isteniyor
            $table->enum('document_type', ['tds', 'sds', 'both'])->default('tds');

            $table->text('message')->nullable();  // İsteğe bağlı not

            // Durum yönetimi (admin panelinden takip)
            $table->enum('status', ['pending', 'sent', 'rejected'])->default('pending');
            $table->timestamp('sent_at')->nullable();

            $table->string('ip_address', 45)->nullable(); // Spam kontrolü için
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
