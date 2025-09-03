<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use WireUi\Traits\Actions;

class AuthController extends Controller
{
    use Actions;

    public function showLoginForm()
    {
        return view('livewire.login');
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

            // Clear OTP after first use
            $user->otp = null;
            $user->save();

            return redirect('/dashboard'); // or home page
        }

        return back()->withErrors(['otp' => 'Invalid phone or OTP']);
    }

    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('login.form');
    }
}

