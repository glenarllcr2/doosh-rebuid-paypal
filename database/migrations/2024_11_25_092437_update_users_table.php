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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('middle_name', 64)->after('first_name')->nullable();
            $table->string('last_name', 128)->after('middle_name')->index();
            $table->string('display_name', 128)->after('last_name')->unique()->nullable();
            $table->enum('gender', ['male', 'female'])->after('display_name')->index();
            $table->string('phone_number')->after('email')->unique();
            $table->date('birth_date')->index()->after('gender')->index();
            $table->enum('status', ['active','pending','rejected','blocked'])->default('pending')->after('birth_date')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->removeColumns(['first_name', 'last_name', 'display_name', 'phone_number', 'gender', 'birth_date', 'status'] );
        });
    }
};
