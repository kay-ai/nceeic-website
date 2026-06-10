<?php
// app/Http/Controllers/Portal/AuthController.php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('hospital')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $hospital = Auth::guard('hospital')->user();

            return match($hospital->application_step) {
                'step2'     => redirect()->route('portal.apply.step2'),
                'step3'     => redirect()->route('portal.apply.step3'),
                'submitted' => redirect()->route('portal.dashboard'),
                default     => redirect()->route('portal.dashboard'),
            };
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password. Please try again.');
    }

    public function logout(Request $request)
    {
        Auth::guard('hospital')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
