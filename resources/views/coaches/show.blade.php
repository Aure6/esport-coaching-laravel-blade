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
                    <div>Coach depuis {{ $coach->created_at_date }}</div>
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
                        <form method="POST" action="/book" class="">
                            @csrf

                            <div class="space-y-1 date-picker">
                                <label for="date">Sélectionne une date</label>
                                <ul>
                                    @php
                                        $weekNumber = 0;
                                    @endphp
                                    @foreach ($dates as $date)
                                        @php
                                            $displayedDate = date('d-m-Y', strtotime($date));
                                            $dayName = date('l', strtotime($date));
                                            $currentWeekNumber = \Carbon\Carbon::parse($date)->weekOfYear;
                                        @endphp
                                        @if ($currentWeekNumber !== $weekNumber)
                                            @if ($weekNumber !== 0)
                            </div> <!-- Close the previous week div -->
                            @endif
                            <div class="flex justify-around row"> <!-- Open a new week div -->
                                @php
                                    $weekNumber = $currentWeekNumber;
                                @endphp
                                @endif
                                <li class="w-full">
                                    <input type="radio" id="{{ $date }}" name="date"
                                        value="{{ $date }}" class="hidden peer" required />
                                    <label for="{{ $date }}"
                                        class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-lime-500 dark:peer-checked:bg-gray-700 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            {{-- <div class="w-full text-lg font-semibold">{{ $date }}</div> --}}
                                            <div class="w-full">{{ __('days.' . $dayName) }} {{ $displayedDate }}</div>
                                        </div>
                                        {{-- <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg> --}}
                                    </label>
                                </li>
                                @endforeach
                            </div> <!-- Close the last week div -->
                            </ul>

                            @foreach ($availabilities as $day => $hours)
                                <div class="day" id="{{ $day }}" style="display: none;">
                                    {{-- <h4>{{ __('days.' . $day) }}</h4> --}}
                                    <legend>Sélectionne les slots d'heure</legend>

                                    @if (empty($hours))
                                        <p>No availability on this day.</p>
                                    @else
                                        @foreach ($hours as $hour)
                                            <div class="hour">
                                                <input type="checkbox" id="{{ $day }}-{{ $hour }}"
                                                    name="hours[]" value="{{ $day }}-{{ $hour }}"
                                                    class="hourCheckbox text-lime-500 focus:ring-lime-600">
                                                <label
                                                    for="{{ $day }}-{{ $hour }}">{{ $hour }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                            <div class="flex justify-center">
                                <x-primary-button type="submit" id="submitButton" disabled
                                    class="cursor-not-allowed">Réserver</x-primary-button>
                            </div>
                        </form>

                        <script>
                            document.querySelectorAll('input[name="date"]').forEach(function(radioButton) {
                                radioButton.addEventListener('change', function() {
                                    var date = new Date(this.value);
                                    var day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][
                                        date.getDay()
                                    ];
                                    document.querySelectorAll('.day').forEach(function(el) {
                                        el.style.display = el.id === day ? 'block' : 'none';
                                    });
                                });
                            });

                            var checkboxes = document.querySelectorAll('.hourCheckbox');
                            var submitButton = document.getElementById('submitButton');

                            checkboxes.forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    var isChecked = Array.from(checkboxes).some(function(checkbox) {
                                        return checkbox.checked;
                                    });
                                    submitButton.disabled = !isChecked;
                                    if (isChecked) {
                                        submitButton.classList.remove('cursor-not-allowed');
                                        submitButton.classList.add('cursor-pointer');
                                    } else {
                                        submitButton.classList.add('cursor-not-allowed');
                                        submitButton.classList.remove('cursor-pointer');
                                    }
                                });
                            });
                        </script>

                        {{-- @forelse ($coach->availabilities as $availability)
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
                        @endforelse --}}
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
