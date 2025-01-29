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
        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('target_id')->index()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('report');
            $table->string('answer')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->index();
            $table->string('page_url')->nullable();
            $table->mediumText('user_agent')->nullable();
            $table->dateTime('review_date')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reports');
    }
};
