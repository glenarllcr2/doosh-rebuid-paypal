<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PaDataForm extends Component
{
    public $fields;
    public $mode;
    public $submitRoute;
    public $data;
    //public $updateField;

    /**
     * Create a new component instance.
     */
    public function __construct($fields, $mode, $submitRoute, $data = null)
    {
        $this->fields = $fields;
        $this->mode = $mode;
        $this->submitRoute = $submitRoute;
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //dd($this->data);
        return view('components.pa-data-form', ['data' => $this->data]);
    }

    /**
     * Get the resource name dynamically from the model.
     */
    protected function getResourceName(): ?string
    {
        if ($this->data) {
            // Extract the resource name from the model's class name
            return strtolower(class_basename($this->data));
        }
        return null;
    }
}
