<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('Auth/register');
    }

    public function __construct()
    {
        $this->middleware('auth');
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
        return redirect()->route('index');
    }

    public   function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('login');
    }

    public function profile()
    {
        return view('userProfile');
    }
    public function userProfileSetting()
    {
        return view('updateUserData');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'organisation' => 'nullable|string',
            'telphone' => 'nullable|string',
            'address' => 'nullable|string',
            'state' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'country' => 'nullable|string',
            'language' => 'nullable|string',
            'timezone' => 'nullable|string',
            'profilepic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->organisation = $request->input('organisation');
        $user->telphone = $request->input('telphone');
        $user->address = $request->input('address');
        $user->state = $request->input('state');
        $user->zipcode = $request->input('zipcode');
        $user->country = $request->input('country');
        $user->language = $request->input('language');
        $user->timezone = $request->input('timezone');

        if ($request->hasFile('profilepic')) {
            if ($user->profilepic) {
                // You may uncomment the line below to delete the previous profile picture
                Storage::delete($user->profilepic);
            }

            $profilepicPath = $request->file('profilepic')->store('profilepics', 'public');
            $user->profilepic = $profilepicPath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
