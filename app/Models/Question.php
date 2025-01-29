<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'question_key', 'answer_type', 'is_editable', 'is_required'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}

