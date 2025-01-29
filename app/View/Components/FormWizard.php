<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormWizard extends Component
{
    public $pages = [];
    public $answers;
    public $formAction;
    public $pageCount;
    /**
     * Create a new component instance.
     */
    public function __construct($questions, $formAction, $answers=[])
    {
        $this->pages = $questions->groupBy('page')->toArray(); 
        $this->pageCount = count($this->pages);      
        $this->formAction = $formAction;
        $this->answers = $answers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-wizard');
    }
}
