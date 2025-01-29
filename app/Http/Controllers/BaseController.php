<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Route;

class BaseController extends Controller 
{
    public static $menu_label = "Menu Label";
    public static $menu_icon = 'bi bi-envelope-fill';
    public static $base_route = '/';

    public static $actions = [];
}