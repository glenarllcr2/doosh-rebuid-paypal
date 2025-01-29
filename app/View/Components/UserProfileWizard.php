<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfileWizard extends Component
{
    public $step;
    public $questions;
    public $previousAnswers;
    public $isNewUser;
    public $totalSteps;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-profile-wizard');
    }
}
