<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question_key');
            $table->string('question');
            $table->enum('answer_type', ['text', 'numeric', 'single_select', 'multi_select', 'boolean']);
            $table->boolean('is_editable')->default(1);
            $table->boolean('is_required')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
