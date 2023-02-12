<?php

namespace App\Access\Login\Http\Controllers;

use App\Access\Login\Http\Requests\ForgetPasswordRequest;
use App\Access\Login\Http\Requests\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(ForgetPasswordRequest $request)
    {
        $validatedFormData = $request->validated();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $validatedFormData['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        SendPasswordResetLink::dispatch(
            $validatedFormData['email'],
            $token
        );

        return back()->with('message', 'Ссылка на восстановление пароля отправлена на вашу почту.');
    }

    public function showResetPasswordForm($token, Request $request)
    {
        $userInPasswordResetsExists = DB::table('password_resets')
            ->where([
                'email' => $request->get('email'),
                'token' => $token
            ])
            ->exists();

        if (!$userInPasswordResetsExists) {
            abort(403);
        }

        return view('auth.forgetPasswordLink', [
            'token' => $token,
            'email' => $request->get('email')
        ]);
    }

    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
        $validatedFormData = $request->validated();

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $validatedFormData['email'],
                'token' => $validatedFormData['token']
            ])
            ->exists();

        if (!$updatePassword) {
            return back()->withInput()->withErrors('status', 'Invalid token.');
        }

        User::where('email', $validatedFormData['email'])
            ->update(['password' => Hash::make($validatedFormData['password'])]);

        DB::table('password_resets')->where(['email' => $validatedFormData['email']])->delete();

        if (Auth::attempt([
            'email' => $validatedFormData['email'],
            'password' => $validatedFormData['password']
        ])) {
            $request->session()->regenerate();
            return redirect('/profile')->with('message', 'Ваш пароль успешно изменён.');
        }
    }
}
