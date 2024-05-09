<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold leading-tight text-gray-800 uppercase">
            {{ $coach->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 overflow-hidden md:grid-cols-3">
                <section class="col-span-1 gap-4 p-6 space-y-8 text-lg text-white uppercase bg-neutral-700">
                    <div class="flex flex-row">
                        <x-avatar class="w-20 h-20" :user="$coach" />
                        <div>
                            <div>{{ $coach->name }}</div>
                            <div class="inline-block p-1 text-sm">{{ $coach->game->name }}</div>
                        </div>
                    </div>
                    {{-- <div>Coach depuis {{ $coach->created_at->diffForHumans() }}</div> --}}
                    <div>Coach depuis {{ $coach->date }}</div>
                    <section>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Succès</h3>
                        <ul>
                            <li>1ère place tournoi 1v1</li>
                        </ul>
                    </section>
                    <section>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Langues</h3>
                        <div>Français</div>
                    </section>
                </section>
                <section class="col-span-2 gap-4 p-6 space-y-8 text-lg text-white bg-neutral-700">
                    <section>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Disponibilités</h3>
                        @forelse ($coach->availabilities as $availability)
                            <ul class="space-y-4">
                                <li class="text-white bg-neutral-700">
                                    <div>{{ $availability->day_of_week }}</div>
                                    <div>{{ $availability->start_time }}</div>
                                    <div>{{ $availability->end_time }}</div>
                                </li>
                            </ul>
                        @empty
                            <div class="p-6 text-lg text-white bg-neutral-700 col-span-full">
                                {{ __('Aucun disponibilité trouvé pour le moment pour le coach ' . $coach->name . '.') }}
                            </div>
                        @endforelse
                    </section>
                    <section>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">A propos</h3>
                        <div>{{ $coach->bio }}</div>
                    </section>
                    <section>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Avis</h3>
                        <ul class="space-y-4">
                            @foreach ($coach->reviews as $review)
                                <li class="text-white bg-neutral-700">
                                    <div>{{ $review->text }}</div>
                                    <div class="text-sm">par <span class="italic">{{ $review->client_name }}</span>
                                        le
                                        {{ $review->created_at->format('d-m-Y') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </section>
            </div>
        </div>
    </div>
</x-guest-layout>
