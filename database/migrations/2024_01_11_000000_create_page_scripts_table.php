<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_scripts', function (Blueprint $table) {
            $table->id();
            $table->string('page_type');
            $table->text('script');
            $table->unsignedInteger('position');
            $table->timestamps();
            $table->unique(['page_type', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_scripts');
    }
};
