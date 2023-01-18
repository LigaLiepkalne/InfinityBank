<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

            Account::create([
                'user_id' => $user->id,
                'number' =>
                    //strtoupper(substr($request->name, 0, 3)) .
                'LV' . str_pad((string)random_int(1, 9999999999), 17, '0', STR_PAD_LEFT), // replace with rand
                'balance' => 0,
                'currency' => 'EUR',
            ]);

        // Generate the code card codes
        /*
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = Str::random(10);
        }
*/
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = str_pad((string)random_int(1, 99999999), 8, '0', STR_PAD_LEFT);
        }
        // Create a new code card for the user
        $codeCard = new CodeCard();
        $codeCard->user_id = $user->id;
        $codeCard->codes = json_encode($codes);
        $codeCard->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
