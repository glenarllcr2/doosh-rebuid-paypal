<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public static $menu_label = "questions.questions";
    public static $menu_icon = 'bi bi-patch-question-fill';
    public static $base_route = 'questions';

    public static $actions = [
        [
            'label' => 'questions.index',
            'icon' => 'bi bi-patch-question-fill',
            'route' => 'questions.index',
        ],

    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin())
            abort(403);

        $search = $request->input('search');
        $sortBy = $request->get('sortBy', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $sortableColumns = ['id', 'question', 'answer_type'];
        $columns = [
            'id' => 'ID',
            'question' => 'Question',
            'answer_type' => 'Answer Type',
            //'created_at' => 'Created At',
        ];

        

        // Check if the column to sort by is valid
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'id'; // default column
        }
        //dd($sortBy, $sortDirection);
        $questions = Question::where('id', $search)
            ->orWhere('question', 'like', '%' . $search . '%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate();

        

        return view('questions.index', [
            'records' => $questions,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'columns' => $columns,
            'sortableColumns' => $sortableColumns,
            'search' => $search, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
