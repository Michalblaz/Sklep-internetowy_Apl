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
           bg-gradient-to-r from-[#ff4d4d] via-[#888888] to-[#00aaff]
           bg-clip-text text-transparent">
            LOG IN
        </h1>

        @if ($errors->any())
            <div class="mb-4 w-full max-w-xl rounded-xl border border-red-400/30 bg-red-500/10 px-5 py-4 text-center text-red-300 shadow-[0_0_20px_rgba(239,68,68,0.12)]">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="w-full flex flex-col gap-6 -ml-30" action="{{ route('log_in') }}" method="POST">
            @csrf

            <div class="flex items-center">
                <label for="email" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">
                    Email :
                </label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       maxlength="254"
                       autocomplete="email"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans"
                       required>
            </div>

            <div class="flex items-center">
                <label for="password" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">
                    Hasło:
                </label>
                <input type="password" id="password" name="password"
                       maxlength="255"
                       autocomplete="current-password"
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans"
                       required>
            </div>

            <div class="flex justify-center gap-8 mt-6 ml-30">

                <button type="submit"
                   class="font-sci-fi text-white text-lg bg-purple-900/40 border-2 border-purple-500/50 rounded-xl
                   px-10 py-4 min-w-[180px] shadow-[0_0_25px_rgba(168,85,247,0.5)]
                   hover:bg-purple-600/60 hover:shadow-[0_0_35px_rgba(168,85,247,0.8)]
                   transition-all duration-300 uppercase tracking-widest">
                    ZALOGUJ
                </button>

                <a href="{{ route('sing_in') }}"
                class="font-sci-fi text-white text-center text-sm bg-purple-900/40 border-2 border-purple-500/50 rounded-xl
                        px-10 py-4 min-w-[180px]
                        shadow-[0_0_25px_rgba(168,85,247,0.5)]
                        hover:bg-purple-600/60 hover:shadow-[0_0_35px_rgba(168,85,247,0.8)]
                        transition-all duration-300 flex items-center justify-center uppercase tracking-tighter">
                    UTWÓRZ KONTO
                </a>

            </div>
        </form>

    </div>
</div>

@endsection
