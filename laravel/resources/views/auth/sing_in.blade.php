@extends('app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

<style>
    .font-sci-fi {
        font-family: 'Orbitron', sans-serif;
    }
</style>

<div class="flex flex-col items-center justify-center py-40">

    <div class="w-full max-w-3xl p-8 flex flex-col items-center">

        <h1 class="font-sci-fi text-8xl font-bold mb-12 tracking-widest text-center
           bg-linear-to-r from-[#ff4d4d] via-[#888888] to-[#00aaff]
           bg-clip-text text-transparent">
            SIGN IN
        </h1>

        @if ($errors->any())
            <div class="text-red-400 mb-4 text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="w-full flex flex-col gap-6 -ml-30" action="/sing_in" method="POST">
            @csrf

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Email :</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Imię :</label>
                <input type="text" name="first_name"
                       value="{{ old('first_name') }}"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Nazwisko :</label>
                <input type="text" name="last_name"
                       value="{{ old('last_name') }}"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Telefon :</label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Hasło :</label>
                <input type="password" name="password"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex items-center">
                <label class="font-sci-fi text-white text-lg w-48 text-right mr-4 uppercase">Powtórz :</label>
                <input type="password" name="password_confirmation"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3">
            </div>

            <div class="flex justify-center gap-6 mt-10 ml-40">

                <button type="submit"
                    class="font-sci-fi text-white text-lg bg-purple-900/40 border-2 border-purple-500/50 rounded-xl
                    px-10 py-4 min-w-45 shadow-[0_0_25px_rgba(168,85,247,0.5)]
                    hover:bg-purple-600/60 hover:shadow-[0_0_35px_rgba(168,85,247,0.8)]
                    transition-all duration-300 uppercase tracking-widest">
                    UTWÓRZ KONTO
                </button>

                <a href="/log_in"
                   class="font-sci-fi text-white text-center text-sm bg-purple-900/40 border-2 border-purple-500/50 rounded-xl
                   px-10 py-4 min-w-45
                   shadow-[0_0_25px_rgba(168,85,247,0.5)]
                   hover:bg-purple-600/60 hover:shadow-[0_0_35px_rgba(168,85,247,0.8)]
                   transition-all duration-300 flex items-center justify-center uppercase tracking-tighter">
                    ZALOGUJ
                </a>

            </div>
        </form>

    </div>
</div>

@endsection
