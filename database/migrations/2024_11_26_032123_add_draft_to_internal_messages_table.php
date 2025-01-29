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
        Schema::table('internal_messages', function (Blueprint $table) {
            $table->enum('status', ['draft', 'sent'])->default('draft')->after('receiver_id')->index(); 
            $table->timestamp('sent_at')->after('status')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internal_messages', function (Blueprint $table) {
            $table->dropColumn(['status', 'sent_at']);
        });
    }
};
