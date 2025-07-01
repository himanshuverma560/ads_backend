<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('city')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->nullable()->after('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->after('state_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
            $table->dropConstrainedForeignId('state_id');
            $table->dropConstrainedForeignId('country_id');
        });
    }
};
