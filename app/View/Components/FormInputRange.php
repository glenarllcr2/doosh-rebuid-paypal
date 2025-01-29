<?php

namespace App\View\Components;
use Illuminate\Contracts\View\View;
class FormInputRange extends BaseFormInput
{
    public $min;
    public $max;
    public $step;

    public function __construct($name, $id = null, $value = null, $label = null, $min = 0, $max = 100, $step = 1, $required = false)
    {
        parent::__construct($name, $id, $value, $label, $required);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }

    public function render(): View|string|\Closure
    {
        return view('components.form-input-range');
    }
}
