<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NouSlider extends Component
{
    public $id;
    public $name;
    public $class;
    public $style;
    public $options;
    public $value;
    public $is_decimal;
    public $tooltipFormat;
    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $name
     * @param string $class
     * @param string $style
     * @param array $options
     */
    public function __construct($id = 'slider', $name='slider', $class = '', $style = '', $options = [], $is_decimal = true, $tooltipFormat="")
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->style = $style;
        $this->options = $options;
        $this->value = "";
        $this->is_decimal = $is_decimal;
        $this->tooltipFormat = $tooltipFormat;
        
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nou-slider');
    }
}
