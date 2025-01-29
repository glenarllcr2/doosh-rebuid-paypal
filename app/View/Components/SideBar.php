<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SideBar extends Component
{
    public $controllers;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->controllers = [
            \App\Http\Controllers\FriendshipController::class,
            \App\Http\Controllers\InternalMessageController::class,
        ];

        if (auth()->user()->isAdmin()) {
            $adminControllers = [
                \App\Http\Controllers\UserController::class,
                \App\Http\Controllers\PlanController::class,
                \App\Http\Controllers\QuestionController::class,
                \App\Http\Controllers\UserReportController::class,
                \App\Http\Controllers\SettingController::class,
                \App\Http\Controllers\SettingExtendController::class,
            ];

            $this->controllers = array_merge($this->controllers, $adminControllers);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $currentRouteName = Route::currentRouteName();
        $currentAction = Request::route()->getActionMethod();
        return view('components.side-bar', [
            'currentRouteName' => $currentRouteName
        ]);
    }
}
