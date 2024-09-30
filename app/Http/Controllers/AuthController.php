<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function AuthPage()
    {
        return view('Pages/auth');
    }

    public function AuthAction(AuthRequest $request)
    {
        $user = Auth::attempt($request->only('email', 'password'));
        if ($user) {
           return \redirect()->route('home');
        } else {
            session()->flash('error', 'Неверные данные для входа.');

            return Redirect::back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth-page');
    }

}
