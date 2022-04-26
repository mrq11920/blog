<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegistrationController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        // case: resend email
        $confirmation_code = Str::random(30);
        if ($user) {
            error_log('user exists');
            $user->confirmation_code = $confirmation_code;
            $user->save();
        } else {
            //create new user
            error_log('create new user');

            User::create([
                'name' => '',
                'password' => 'sdflksjdlfw3',
                'email' => $email,
                'confirmation_code' => $confirmation_code
            ]);
        }

        Mail::send('email.verify', ['confirmation_code' => $confirmation_code], function ($message) use ($email) {
            $message
                ->to($email, 'some username')
                ->subject('Verify your email address');
        });

        return redirect()->back()->with('success', 'An email has been sent to your email address');
    }

    public function confirm($confirmation_code)
    {

        if (!$confirmation_code) {
            error_log($confirmation_code);
            // throw new InvalidConfirmationCodeException;
        }

        $user = User::where('confirmation_code',$confirmation_code)->first();

        if (!$user) {
            // throw new InvalidConfirmationCodeException;
            error_log($confirmation_code);
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        // Flash::message('You have successfully verified your account.');

        return view('register.confirm', ['email' => $user->email]);
    }

}
