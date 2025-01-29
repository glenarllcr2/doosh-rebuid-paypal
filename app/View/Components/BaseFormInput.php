<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseFormInput extends Component
{
    //public $qid;
    public $id;
    public $name;
    public $value;
    public $label;
    public $required;
    public $class;
    public $style;
    public $floating;

    public function __construct(
        //int $qid = 1,
        string $id = null,
        string $name,
        $value = null,
        string $label = null,
        bool $required = false,
        string $class = '',
        string $style = '',
        bool $floating = false
    ) {
        //$this->qid = $qid;
        $this->id = $id ?? $name;
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->class = $class;
        $this->style = $style;
        $this->floating = filter_var($floating, FILTER_VALIDATE_BOOLEAN);
    }

    public function render(): View|string|\Closure
    {
        return view('components.base-form-input');
    }
}
