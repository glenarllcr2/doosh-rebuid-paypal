<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'mid_name' => [ 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'birth_date' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->toDateString()],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role_id' => 4,
            'first_name'    => $request->first_name ,
            'middle_name'   => $request->mid_name,
            'last_name' => $request->last_name,
            'display_name'  => $request->display_name,
            'gender'    => $request->gender ,
            'phone_number'  => $request->phone_number,
            'email' => $request->email ,
            'birth_date'    => $request->birth_date,
            
            'status'    => 'pending',
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => 3,
            'start_date' => now(),
            'end_date'=> now()->addYear(),
        ]);
        Auth::login($user);



        return redirect(route('profile.edit', absolute: false));
    }
}
