<x-app-layout>
    <div x-data="{
        images: [
            '{{ asset('storage/background1.jpg') }}',
            '{{ asset('storage/background2.jpg') }}',
            '{{ asset('storage/background3.jpg') }}'
        ],
        currentIndex: 0,
        isFading: false,
        switchImage() {
            this.isFading = true;
            setTimeout(() => {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
                this.isFading = false;
            }, 1000); // Duration should match CSS transition
        },
        startSwitching() {
            setInterval(() => {
                this.switchImage();
            }, 5000);
        }
    }" x-init="startSwitching()" class="relative bg-black" style="height: calc(100vh - 64px);">
        <div class="absolute inset-0 transition-opacity duration-1000"
            :class="{ 'opacity-0': isFading, 'opacity-100': !isFading }">
            <img :src="images[currentIndex]" class="object-cover object-center w-full h-full"
                alt="a player playing a videogame" />
        </div>
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center max-w-4xl gap-8 mx-auto">
            <h1 class="text-3xl font-black leading-tight text-center text-white uppercase">
                {{ __('Améliorez votre jeu, atteignez votre potentiel maximum avec nos coachs experts en jeux vidéo.') }}
            </h1>
            <a href="{{ route('games.index') }}"
                class="inline-flex items-center px-10 py-5 font-black tracking-wider text-black uppercase transition duration-150 ease-in-out border border-transparent rounded-md sm:text-3xl bg-lime-400 hover:text-white hover:bg-lime-700 focus:bg-lime-700 active:bg-lime-900 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2">
                {{ __('Réserve ta session') }}
            </a>
        </div>
    </div>

    <div class="py-12 space-y-8">
        <div class="max-w-4xl p-6 mx-auto text-xl sm:px-6 lg:px-8">
            Nos coachs prodiguent un encadrement d'excellence, fruit d'une sélection rigoureuse. Ce sont des pégagogues
            chevronnés qui maitrisent les rouages du jeu, la technique et les clés de la réussite
        </div>
        <div class="mx-auto space-y-4 sm:px-6 lg:px-8">
            <x-section-title class="p-6">Les meilleurs coachs</x-section-title>
            <div class="grid grid-cols-1 gap-6 p-4 overflow-hidden sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5">
                {{-- <Link :href="route('games.show', { gameId: game.id, })" v-for="game in  games" :key="game.id"
                        class="block p-6 text-2xl text-white uppercase duration-200 bg-neutral-700 hover:bg-neutral-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500">
                    {{ game.name }}
                    </Link> --}}
                @forelse ($coaches as $coach)
                    <a href="{{ route('coaches.show', $coach->id) }}"
                        class="flex flex-col gap-4 p-6 text-lg text-white uppercase duration-200 sm:rounded-xl bg-neutral-700 hover:bg-neutral-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 hover:scale-105">
                        <x-avatar class="w-20 h-20 mx-auto" :user="$coach" />
                        <div>{{ $coach->name }}</div>
                        <div class="inline-block p-1 text-sm">{{ $coach->game->name }}</div>
                    </a>
                @empty
                    <div class="p-6 text-lg text-white bg-neutral-700 col-span-full">
                        {{ __('Aucun coach disponible pour le moment pour le jeu ' . $game->name . '.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
