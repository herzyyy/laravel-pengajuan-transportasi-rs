<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            // Jika sudah login dan akses /login, arahkan sesuai role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // Find user by first_name and last_name
        $user = \App\Models\User::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['first_name' => 'Nama atau password salah.'])
                ->onlyInput('first_name', 'last_name');
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Setelah login berhasil, arahkan sesuai role
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

