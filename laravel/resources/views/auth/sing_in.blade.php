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
            SING IN
        </h1>

        <form class="w-full flex flex-col gap-6 -ml-30" action="#" method="POST">
            @csrf

            <div class="flex items-center">
                <label for="email" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">Email :</label>
                <input type="----" id="----" name="----" 
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans">
            </div>

            <div class="flex items-center">
                <label for="imie" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">Imie :</label>
                <input type="----" id="----" name="----" 
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans">
            </div>

            <div class="flex items-center">
                <label for="nazwisko" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">Nazwisko :</label>
                <input type="----" id="----" name="----" 
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans">
            </div>

            <div class="flex items-center">
                <label for="numer" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">Numer telefonu :</label>
                <input type="----" id="----" name="----" 
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans">
            </div>

            <div class="flex items-center">
                <label for="password" class="font-sci-fi text-white text-lg w-48 text-right mr-4 tracking-wide uppercase">Hasło :</label>
                <input type="----" id="----" name="----" 
                       class="flex-1 bg-gray-200 text-gray-900 rounded-sm px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 font-sans">
            </div>

            <div class="flex justify-center gap-6 mt-10 ml-40">
                <button type="submit" 
                        class="font-sci-fi text-white text-lg bg-purple-900/40 border-2 border-purple-500/50 rounded-xl 
                   px-10 py-4  min-w-[180px] shadow-[0_0_25px_rgba(168,85,247,0.5)] 
                   hover:bg-purple-600/60 hover:shadow-[0_0_35px_rgba(168,85,247,0.8)] 
                   transition-all duration-300 uppercase tracking-widest">
                        UTWÓRZ KONTO
                    
                </button>

                <a href="/log_in" 
                    class="font-sci-fi text-white text-center text-sm bg-purple-900/40 border-2 border-purple-500/50 rounded-xl 
                        px-10 py-4 
                        min-w-[180px]
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