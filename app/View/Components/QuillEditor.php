<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuillEditor extends Component
{
    public $name;
    public $id;
    public $style;
    public $theme;
    public $placeholder;
    public $modules;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $id, $style, $theme, $placeholder, $modules)
    {
        $this->name = $name;
        $this->id = $id;
        $this->style = $style;
        $this->theme = $theme;
        $this->placeholder = $placeholder;
        $this->modules = $modules;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.quill-editor');
    }
}
