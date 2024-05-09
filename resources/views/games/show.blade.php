<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold leading-tight text-gray-800 uppercase">
            {{ __('Trouve ton coach parfait pour une session en direct dans ') }}{{ $game->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 overflow-hidden md:grid-cols-3">
                {{-- <Link :href="route('games.show', { gameId: game.id, })" v-for="game in  games" :key="game.id"
                        class="block p-6 text-2xl text-white uppercase duration-200 bg-neutral-700 hover:bg-neutral-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500">
                    {{ game.name }}
                    </Link> --}}
                @forelse ($coaches as $coach)
                    <a href="{{ route('coaches.show', $coach->id) }}"
                        class="flex flex-row gap-4 p-6 text-lg text-white uppercase duration-200 bg-neutral-700 hover:bg-neutral-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 hover:scale-105">
                        <x-avatar class="w-20 h-20" :user="$coach" />
                        <div>{{ $coach->name }}</div>
                    </a>
                @empty
                    <div class="p-6 text-lg text-white bg-neutral-700 col-span-full">
                        {{ __('Aucun coach disponible pour le moment pour le jeu ' . $game->name . '.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-guest-layout>
