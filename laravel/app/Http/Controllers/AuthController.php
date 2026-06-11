<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.log_in');
    }

    public function showSinginForm(): View
    {
        return view('auth.sing_in');
    }

    public function login(Request $request): RedirectResponse
    {
        $email = $request->input('email');

        $request->merge([
            'email' => is_string($email) ? Str::lower(trim($email)) : $email,
        ]);

        $data = $request->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:254'],
            'password' => ['required', 'string', 'max:255'],
        ], [
            'email.required' => 'Email jest wymagany.',
            'email.email' => 'Podaj poprawny adres email.',
            'password.required' => 'Hasło jest wymagane.',
        ]);

        $throttleKey = $this->loginThrottleKey($data['email'], $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Zbyt wiele prób logowania. Spróbuj ponownie za {$seconds} sekund.",
            ]);
        }

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password_hash)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors(['email' => 'Nieprawidłowy email lub hasło.'])
                ->withInput($request->only('email'));
        }

        $blockedAccountMessage = $this->blockedAccountMessage($user);

        if ($blockedAccountMessage !== null) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors(['account' => $blockedAccountMessage])
                ->withInput($request->only('email'));
        }

        RateLimiter::clear($throttleKey);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Zalogowano pomyślnie!');
    }

    public function register(Request $request): RedirectResponse
    {
        $email = $request->input('email');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $phone = $request->input('phone');

        $request->merge([
            'email' => is_string($email) ? Str::lower(trim($email)) : $email,
            'first_name' => is_string($firstName) ? trim($firstName) : $firstName,
            'last_name' => is_string($lastName) ? trim($lastName) : $lastName,
            'phone' => is_string($phone) && trim($phone) !== '' ? trim($phone) : null,
        ]);

        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:100', "regex:/^[\\pL\\pM '\\-]+$/u"],
            'last_name' => ['required', 'string', 'min:2', 'max:100', "regex:/^[\\pL\\pM '\\-]+$/u"],
            'email' => ['required', 'string', 'email:rfc', 'max:254', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+() .-]+$/'],
            'password' => ['required', 'string', 'confirmed', 'max:255', Password::min(8)->letters()->numbers()],
        ], [
            'first_name.required' => 'Imię jest wymagane.',
            'first_name.regex' => 'Imię zawiera niedozwolone znaki.',
            'last_name.required' => 'Nazwisko jest wymagane.',
            'last_name.regex' => 'Nazwisko zawiera niedozwolone znaki.',
            'email.required' => 'Email jest wymagany.',
            'email.email' => 'Podaj poprawny adres email.',
            'email.unique' => 'Ten email jest już zajęty.',
            'phone.regex' => 'Podaj poprawny numer telefonu.',
            'password.required' => 'Hasło jest wymagane.',
            'password.confirmed' => 'Hasła muszą być takie same.',
        ]);

        $user = DB::transaction(fn () => User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'password_hash' => Hash::make($data['password']),
            'is_Admin' => false,
        ]));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Konto zostało utworzone!');
    }

    public function logout(Request $request): RedirectResponse
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

        if (! $latestBan) {
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
            if (now()->lt(Carbon::parse($endTime))) {
                return 'Konto jest zawieszone.';
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    private function loginThrottleKey(string $email, string $ip): string
    {
        return 'login|' . Str::transliterate(Str::lower($email)) . '|' . $ip;
    }
}
