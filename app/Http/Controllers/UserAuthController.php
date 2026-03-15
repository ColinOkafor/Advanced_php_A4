<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    //

    function authenticate(Request $request) : RedirectResponse 
    {
        $credentials = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required']
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            return redirect()->intended("listbuilder");
        }

        return back()->withErrors([
            "email" => "The provided credentials do not match our records"
        ])->onlyInput("email");
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect("/login");
    }
    

    function displayRegisterPage()
    {
        return view("register");
    }

    function displayLoginPage()
    {
        return view("login");
    }

    function registerUser(Request $request) : RedirectResponse
    {
        $user = new User;
        $user->password = Hash::make( $request->input("password") );
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->save();

        return redirect("/login");
    }

}
