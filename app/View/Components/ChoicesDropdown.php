<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChoicesDropdown extends Component
{
    public string $id;
    public string $name;
    public string $searchUrl;
    public string $fieldName;
    public string $styles;
    public string $placeholder;
    public bool $searchEnabled;
    public string $searchPlaceholderValue;
    public string $noResultsText;
    public bool $shouldSort;
    public bool $removeItemButton;
    public ?User $receiverUser; // نوع‌دهی مشخص برای User

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id,
        string $name,
        string $searchUrl,
        string $fieldName = 'name',
        string $styles = '',
        string $placeholder = '',
        bool $searchEnabled = true,
        string $searchPlaceholderValue = 'Type to search...',
        string $noResultsText = 'No results found',
        bool $shouldSort = false,
        bool $removeItemButton = true,
        ?User $receiverUser = null // مقدار پیش‌فرض null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->searchUrl = $searchUrl;
        $this->fieldName = $fieldName;
        $this->styles = $styles;
        $this->placeholder = $placeholder;
        $this->searchEnabled = $searchEnabled;
        $this->searchPlaceholderValue = $searchPlaceholderValue;
        $this->noResultsText = $noResultsText;
        $this->shouldSort = $shouldSort;
        $this->removeItemButton = $removeItemButton;
        $this->receiverUser = $receiverUser instanceof User ? $receiverUser : null; // بررسی نوع داده
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.choices-dropdown', [
            'receiverUser' => $this->receiverUser,
        ]);
    }
}
