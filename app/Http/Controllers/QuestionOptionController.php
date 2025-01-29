<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionOptionController extends BaseController
{
    public static $menu_label = "questions.questions";
    public static $menu_icon = 'bi bi-envelope-fill';
    public static $base_route = 'question-options';

    // public static $actions = [
    //     [
    //         'label' => 'questions.churchs',
    //         'icon' => 'bi bi-envelope-arrow-down-fill',
    //         'route' => 'question-options'
    //     ],

    // ];
    public function index(Request $request)
    {
        $questions = Question::whereIn('answer_type', ['single_select', 'multi_select'])
            ->orderBy($request->get('sortColumn', 'id'), $request->get('sortDirection', 'asc'))
            ->paginate($request->get('perPage', 10));

        
        $columns = [
            'id' => 'ID',
            'question' => 'Question',
            'created_at' => 'Created At',
        ];

        $sortableColumns = ['id', 'question', 'created_at'];

        return view('question-options.index', compact('questions','columns', 'sortableColumns'))->with('route', 'question-options.index');
    }

    public function edit($id)
    {
        $questionOption = QuestionOption::findOrFail($id);

        // ارسال به view برای ویرایش
        return view('question-options.edit', compact('questionOption'));
    }

    // بروزرسانی یک گزینه سوال
    public function update(Request $request, $id)
    {
        $request->validate([
            'option_value' => 'required|string|max:255',
        ]);

        $questionOption = QuestionOption::findOrFail($id);
        $questionOption->update($request->all());

        return redirect()->route('questions.show', $questionOption->question)->with('success', 'Question Option updated successfully');
    }

    // حذف یک گزینه سوال
    public function destroy($id)
    {
        $questionOption = QuestionOption::findOrFail($id);
        $questionOption->delete();

        return redirect()->route('question-options.index')->with('success', 'Question Option deleted successfully');
    }

    public function show($id)
    {
        
        $questionOption = QuestionOption::findOrFail($id);

        // ارسال به view برای نمایش جزئیات
        return view('question-options.show', compact('questionOption'));
    }
}
