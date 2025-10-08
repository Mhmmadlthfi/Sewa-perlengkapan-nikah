<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', ['title' => 'Login Admin']);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::find(Auth::id());

            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->with('loginError', 'Anda bukan admin, silahkan akses aplikasi mobile kami.');
            }

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('loginError', 'Akun Anda tidak aktif. Hubungi Owner untuk informasi lebih lanjut.');
            }

            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->with('loginError', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
