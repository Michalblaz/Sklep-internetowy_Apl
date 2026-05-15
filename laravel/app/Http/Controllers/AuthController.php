<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'password' => ['required'],
        ], [
            'email.required' => 'Email jest wymagany',
            'email.email' => 'Podaj poprawny adres email',
            'password.required' => 'Hasło jest wymagane',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Nieprawidłowy email lub hasło'])
                ->withInput();
        }

        $blockedAccountMessage = $this->blockedAccountMessage($user);

        if ($blockedAccountMessage !== null) {
            return back()
                ->withErrors(['account' => $blockedAccountMessage])
                ->withInput($request->only('email'));
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
        ], [
            'first_name.required' => 'Imię jest wymagane',
            'first_name.max' => 'Imię może mieć maksymalnie 255 znaków',

            'last_name.required' => 'Nazwisko jest wymagane',
            'last_name.max' => 'Nazwisko może mieć maksymalnie 255 znaków',

            'email.required' => 'Email jest wymagany',
            'email.email' => 'Podaj poprawny adres email',
            'email.unique' => 'Ten email jest już zajęty',

            'password.required' => 'Hasło jest wymagane',
            'password.min' => 'Hasło musi mieć minimum 6 znaków',
            'password.confirmed' => 'Hasła muszą być takie same',
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

    private function blockedAccountMessage(User $user): ?string
    {
        $latestBan = DB::table('bans')
            ->where('id_users', $user->id)
            ->orderByDesc('id')
            ->first(['end_time']);

        if (!$latestBan) {
            return null;
        }

        $endTime = $latestBan->end_time;

        if ($endTime === null || (
            is_string($endTime)
            && in_array(strtolower(trim($endTime)), ['infinity', 'infinite'], true)
        )) {
            return 'Konto jest zbanowane.';
        }

        try {
            if (now()->lt(\Carbon\Carbon::parse($endTime))) {
                return 'Konto jest zawieszone.';
            }
        } catch (\Throwable $exception) {
            return null;
        }

        return null;
    }
}
