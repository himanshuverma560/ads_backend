<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address');
            $table->timestamps();
            $table->unique(['profile_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_views');
    }
};
