<?php
namespace App\View\Components;

use Illuminate\View\Component;

class MultiRangeSlider extends Component
{
    public $id;
    public $name;
    public $min;
    public $max;
    public $start;
    public $decimal;
    public $showTooltip;
    public $tooltipSuffix;
    public $format;  // اضافه کردن فرمت

    public function __construct($id="slider", $name="slider", $min = 0, $max = 100, $start = [0, 100], $decimal = false, $showTooltip = true, $tooltipSuffix = '', $format = 'decimal')
    {
        $this->min = $min;
        $this->max = $max;
        $this->start = $start;
        $this->decimal = $decimal;
        $this->showTooltip = $showTooltip;
        $this->tooltipSuffix = $tooltipSuffix;
        $this->id = $id;
        $this->name = $name;
        $this->format = $format;  // دریافت فرمت
    }

    public function render()
    {
        return view('components.multi-range-slider');
    }
}
