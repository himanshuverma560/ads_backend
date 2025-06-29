<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('mobile');
            $table->string('snapchat')->nullable()->after('whatsapp');
            $table->string('video_call_link')->nullable()->after('snapchat');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['whatsapp', 'snapchat', 'video_call_link']);
        });
    }
};
