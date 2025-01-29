<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('is_active')->after('name')->default(true)->nullable();
            $table->boolean('is_recommanded')->after('is_active')->default(false)->nullable();
            $table->integer('duration')->default(30)->index()->after('is_recommanded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'is_recommanded', 'duration']);
        });
    }
};
