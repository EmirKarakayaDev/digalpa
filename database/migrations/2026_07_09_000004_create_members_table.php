<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Panele giriş yapmayan, sadece bildirim alıcısı olarak tutulan
        // kayıtlar (Brief §06: "dahili bildirim" — admin login değil).
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->boolean('receives_notifications')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // site.email zaten dahili bildirim hedefi olarak kullanılıyordu —
        // özellik sessizce boşta kalmasın diye ilk üyeyi oradan taşıyoruz.
        $siteEmail = DB::table('site_settings')->where('key', 'site.email')->value('value');

        if ($siteEmail) {
            DB::table('members')->insert([
                'name'                    => 'Genel Bildirim',
                'email'                   => $siteEmail,
                'receives_notifications'  => true,
                'is_active'               => true,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
