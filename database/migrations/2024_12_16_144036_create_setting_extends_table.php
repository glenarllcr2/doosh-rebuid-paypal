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
        Schema::create('setting_extends', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->enum('type', ['numeric', 'boolean', 'image', 'short_text', 'text_area', 'wysiwyg']);
            $table->json('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_extends');
    }
};
