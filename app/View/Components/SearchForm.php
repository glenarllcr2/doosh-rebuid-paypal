<?php

namespace App\View\Components;

use App\Models\Question;
use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchForm extends Component
{
    public $churchOptions;
    public $livingPlaceOptions;
    public $educationLevelOptions;
    public $industryOptions;
    public $currentUser;
    public $minAge;
    public $maxAge;
    public $mode;
    
    /**
     * Create a new component instance.
     */
    public function __construct($mode="popup")
    {
        $this->mode = $mode;
        $this->currentUser = auth()->user();
        $this->getOptions();
        // $question = Question::where('question_key', 'church')->first();
        // $livingPlaceOptions = Question::where('question_key', 'church')->first();
        
        // if ($question) {
        //     $this->churchOptions = $question->options()->get();
        // } else {
        //     $answers = collect(); 
        // }
        $ageBetween = 10;
        $ageSetting = Setting::where('key', 'age_between')->first();
        //dd($ageBetween);
        if($ageSetting)
            $ageBetween = intVal($ageSetting->value);
        if($this->currentUser->gender == 'male') {
            $this->maxAge = $this->currentUser->age;
            $this->minAge = $this->currentUser->age - $ageBetween;
        } else {
            $this->minAge = $this->currentUser->age;
            $this->maxAge = $this->currentUser->age - $ageBetween;
        }
    }

    public function getOptions()
    {
        $churchs = Question::where('question_key', 'church')->first();
        $this->churchOptions = $churchs->options()->get();
        
        $livingPlaces = Question::where('question_key', 'country_live')->first();
        $this->livingPlaceOptions = $livingPlaces->options()->get();

        $educationLevel = Question::where('question_key', 'education')->first();
        $this->educationLevelOptions = $educationLevel->options()->get();

        $industries = Question::where('question_key', 'industry')->first();
        $this->industryOptions = $industries->options()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if($this->mode =="popup")
            return view('components.search-form',[
                'churchOptions' => $this->churchOptions,
                'livingPlaceOptions' => $this->livingPlaceOptions,
                'educationLevelOptions' => $this->educationLevelOptions,
                'industryOptions' => $this->industryOptions,
                'min_age' => $this->minAge,
                'max_age' => $this->maxAge,
            ]);

        else {
            return view('components.search-form-responsive',[
                'churchOptions' => $this->churchOptions,
                'livingPlaceOptions' => $this->livingPlaceOptions,
                'educationLevelOptions' => $this->educationLevelOptions,
                'industryOptions' => $this->industryOptions,
                'min_age' => $this->minAge,
                'max_age' => $this->maxAge,
            ]);
        }
    }
}
