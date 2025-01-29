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
        DB::statement('
            CREATE VIEW user_question_answers AS
            SELECT 
                u.id,
                u.display_name,
                u.birth_date,
                u.status,
                u.gender,
                q.question_key,
                q.question,
                ua.answer_value
            FROM 
                users u
            JOIN 
                user_answers ua ON u.id = ua.user_id
            JOIN 
                questions q ON ua.question_id = q.id;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_question_answers');
    }
};
