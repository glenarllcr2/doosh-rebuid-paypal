<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    public $user;
    public $mode;
    /**
     * Create a new component instance.
     */
    public function __construct($user, $mode)
    {
        $this->user = $user;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-card', [
            'user' => $this->user,
            'mode' => $this->mode
        ]);
    }
}
