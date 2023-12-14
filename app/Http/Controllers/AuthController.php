<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('Auth/register');
    }

    public function StoreUsers()
    {

        //validate all input
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
            // 'userid' => 'required'
        ]);

        $randNumber = rand(10000, 99999);
        $userid = 'user_' . $randNumber;

        User::create([
            'userid' => $userid,
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('Auth/login');
    }


    //login user in

    public function __LoginUSer(Request $request)
    {

        // validate Data
        validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'message' => 'Pls Check your Credentials and try again'
            ]);
        }
        $request->session()->regenerate();
        return view('index');
    }

    public   function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('login');
    }
}
