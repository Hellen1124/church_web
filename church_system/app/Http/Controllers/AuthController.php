<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
   

    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
                    ->where('otp', $request->otp)
                    ->first();

        if ($user) {
            // OTP verified → log in
            Session::put('user_id', $user->id);

            // Clear OTP after use
            $user->otp = null;
            $user->save();

            return redirect('/dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid phone or OTP']);
    }

    public function resendOtp(FakeSmsService $smsService, Request $request)
    {
        $phone = $request->session()->get('phone');

        if (!$phone) {
            return redirect()->route('login.form')->withErrors([
                'phone' => 'Session expired. Please register again.'
            ]);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);

        $user = User::where('phone', $phone)->first();
        if ($user) {
            $user->otp = $otp;
            $user->save();

            $smsService->sendSms($phone, "Your new OTP is: {$otp}");

            return back()->with('status', 'A new OTP has been sent to your phone.');
        }

        return redirect()->route('login.form')->withErrors([
            'phone' => 'User not found. Please register again.'
        ]);
    }

    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('login.form');
    }
}

