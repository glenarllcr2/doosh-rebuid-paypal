<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MessagesTable extends Component
{
    public $routePrefix;
    public $targetSort;
    public $sortColumn;
    public $sortDirection;
    public $targetUserDisplayName;
    public $messages;
    public $mode;
    /**
     * Create a new component instance.
     */
    public function __construct( $routePrefix, $targetSort, $sortColumn, $sortDirection, $targetUserDisplayName, $messages, $mode)
    {
        $this->routePrefix = $routePrefix;
        $this->targetSort = $targetSort;
        $this->sortColumn = $sortColumn;
        $this->sortDirection = $sortDirection;
        $this->targetUserDisplayName = $targetUserDisplayName;
        $this->messages = $messages;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.messages-table');
    }
}
