<x-app-layout>
    <div class="relative" style="height: calc(100vh - 64px);">
        <img class="object-cover object-center w-full h-full" src="{{ asset('storage/background.jpg') }}"
            alt="a player playing a videogame" />
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center max-w-4xl gap-8 mx-auto">
            <h1 class="text-3xl font-black leading-tight text-center text-white uppercase">
                {{ __('Améliorez votre jeu, atteignez votre potentiel maximum avec nos coachs experts en jeux vidéo.') }}
            </h1>
            <a href="{{ route('games.index') }}"
                class="inline-flex items-center px-4 py-4 font-black tracking-wider text-black uppercase transition duration-150 ease-in-out border border-transparent rounded-md bg-lime-400 hover:text-white hover:bg-lime-700 focus:bg-lime-700 active:bg-lime-900 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2">
                {{ __('Réserve ta session') }}
            </a>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        </div>
    </div>
</x-app-layout>
