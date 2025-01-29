<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubscriptionCard extends Component
{
    public $duration;
    public $price;
    public $name;
    public $recommended;
    /**
     * Create a new component instance.
     */
    public function __construct($duration, $price, $name, $recommended = false)
    {
        $this->duration = $duration;
        $this->price = $price;
        $this->name = $name;
        $this->recommended = $recommended;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.subscription-card');
    }
}
