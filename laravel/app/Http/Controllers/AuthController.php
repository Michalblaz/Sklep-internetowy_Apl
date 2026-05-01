<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // FORMULARZE
    public function showLoginForm()
    {
        return view('auth.log_in');
    }

    public function showSinginForm()
    {
        return view('auth.sing_in');
    }

    // LOGIN
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Nieprawidłowy email lub hasło'])
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Zalogowano pomyślnie!');
    }

    // REGISTER
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['nullable', 'string'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password_hash' => Hash::make($data['password']),
            'is_Admin' => false,
        ]);

        Auth::login($user);

        return redirect('/')
            ->with('success', 'Konto zostało utworzone!');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/log_in');
    }
}
