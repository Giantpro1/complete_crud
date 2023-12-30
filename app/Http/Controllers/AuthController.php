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

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


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

    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('login');
    }

    public function profile()
    {
        return view('userProfile');
    }
    public function userSecuritySetting()
    {
        return view('userSecuritySetting');
    }
    public function userProfileSetting()
    {
        $languages = [
            'English', 'French', 'German', 'Portuguese',
        ];

        // $currencies = [
        //     'USD', 'Euro', 'Pound', 'Bitcoin',
        // ];

        $timezones = [
            '(GMT-12:00) International Date Line West',
            '(GMT-11:00) Midway Island, Samoa',
            '(GMT-10:00) Hawaii',
            '(GMT-09:00) Alaska',
            '(GMT-08:00) Pacific Time (US & Canada)',
            '(GMT-08:00) Tijuana, Baja California',
            '(GMT-07:00) Arizona',
            '(GMT-07:00) Chihuahua, La Paz, Mazatlan',
            '(GMT-07:00) Mountain Time (US & Canada)',
            '(GMT-06:00) Central America',
            '(GMT-06:00) Central Time (US & Canada)',
            '(GMT-06:00) Guadalajara, Mexico City, Monterrey',
            '(GMT-06:00) Saskatchewan',
            '(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
            '(GMT-05:00) Eastern Time (US & Canada)',
            '(GMT-05:00) Indiana (East)',
            '(GMT-04:00) Atlantic Time (Canada)',
            '(GMT-04:00) Caracas, La Paz',
            // ... add more time zones as needed
        ];

        $countries = [
            'Australia', 'Bangladesh', 'Belarus', 'Brazil', 'Canada', 'China',
            'France', 'Germany', 'India', 'Indonesia', 'Israel', 'Italy', 'Japan',
            'Korea, Republic of', 'Mexico', 'Philippines', 'Russian Federation',
            'South Africa', 'Thailand', 'Turkey', 'Ukraine', 'United Arab Emirates',
            'United Kingdom', 'United States',
        ];

        return view('updateUserData',   [
            'countries' => $countries,
            'languages' => $languages,
            'timezones' => $timezones,
            // 'currencies' => $currencies,
        ]);
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'confirmPassword' => 'required|string|same:newPassword',
        ]);

        $user = auth()->user();

        // Check if the current password matches the user's password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        // Update the user's password using Hash::make()
        $user->update(['password' => Hash::make($request->newPassword)]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
