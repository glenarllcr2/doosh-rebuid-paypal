<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function upgrade()
    {
        $plans = Plan::where('is_active', 1)
            ->orderBy('is_recomended')
            ->get();

        return view('Subscription.upgrade',['plans' => $plans]);
    }
}
