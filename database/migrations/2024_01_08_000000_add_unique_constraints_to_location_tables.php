<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->unique('name');
        });
        Schema::table('states', function (Blueprint $table) {
            $table->unique('name');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropUnique('countries_name_unique');
        });
        Schema::table('states', function (Blueprint $table) {
            $table->dropUnique('states_name_unique');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique('cities_name_unique');
        });
    }
};
