<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->foreignId('state_id')->after('name')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable()->after('state_id');
        });
    }

    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('state_id');
            $table->dropColumn('image');
        });
    }
};
