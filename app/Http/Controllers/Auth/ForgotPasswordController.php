<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send custom reset password email
     */
    public function sendResetLinkEmail(Request $request)
    {
        App::setLocale(checkLanguageSession());

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => __('messages.common.we_cant_find_user'),
            ]);
        }

        $token = encrypt($user->email . $user->id);

        $link = url('/createNewPassword?token=' . $token . '&email=' . $user->email);

        $data = [
            'full_name' => $user->full_name,
            'link' => $link,
        ];

        Mail::to($user->email)->send(new ForgotPasswordMail($data));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        return back()->with(
            'status',
            __('messages.common.we_have_your_password_resetk_link')
        );
    }
}