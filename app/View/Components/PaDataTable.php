<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PaDataTable extends Component
{
    public $records;
    public $columns;
    public $sortableColumns;
    //public $questionKey;
    public $sortColumn;
    public $sortDirection;
    public $route;
    public $actions;
    public $createRoute;
    public $exportRoute;
    public $importRoute;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $records,
        $columns,
        $sortableColumns,
        $sortColumn,
        $sortDirection,
        $route,
        $actions = ['view', 'edit', 'delete'],
        $createRoute = null,
        $exportRoute = null,
        $importRoute = null
    ) {
        $this->records = $records;
        $this->columns = $columns;
        $this->sortableColumns = $sortableColumns;
        $this->sortColumn = $sortColumn;
        $this->sortDirection = $sortDirection;
        $this->route = $route;
        $this->actions = $actions;
        $this->createRoute = $createRoute;
        $this->exportRoute = $exportRoute;
        $this->importRoute = $importRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pa-data-table');
    }
}
