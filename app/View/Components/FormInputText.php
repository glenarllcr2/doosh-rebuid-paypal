<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

class FormInputText extends BaseFormInput
{
    public $value;

    public function __construct(
        // int $qid = 1,
        string $name,
        string $id = null,
        string $class = '',
        string $style = '',
        bool $required = false,
        string $label = '',
        bool $floating = false,
        string $value = ''
    ) {

        parent::__construct(
            // $qid, 
            $id,
            $name,
            $value,
            $label,
            $required,
            $class,
            $style,
            $floating
        );
        $this->value = $value;
    }

    public function render(): View|string|\Closure
    {
        return view('components.form-input-text');
    }
}
