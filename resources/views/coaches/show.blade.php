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
                <section class="col-span-2 gap-4 space-y-8 text-lg text-white ">
                    <section class="p-6 bg-neutral-700">
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Disponibilités</h3>
                        @if ($errors->any())
                            <div class="bg-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('appointments.store') }}" class="">
                            @csrf

                            <div class="space-y-1 date-picker">
                                <label for="date">Sélectionne une date</label>
                                <ul>
                                    @php
                                        $weekNumber = 0;
                                    @endphp
                                    @forelse ($availabilities as $date => $hours)
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
                                    </label>
                                </li>
                            @empty
                                <div>
                                    {{ __('Aucun disponibilité trouvé pour le moment pour le coach ' . $coach->name . '.') }}
                                </div>
                                @endforelse
                            </div> <!-- Close the last week div -->
                            </ul>

                            @foreach ($availabilities as $date => $hours)
                                <div class="day" id="{{ $date }}" style="display: none;">
                                    {{-- <h4>{{ __('days.' . $day) }}</h4> --}}
                                    <legend>Sélectionne un ou plusieurs slots d'heure pour le jour sélectionné</legend>

                                    @if (empty($hours))
                                        <p>No availability on this day.</p>
                                    @else
                                        <p>Durée d'un service: 1 heure.</p>
                                        @foreach ($hours as $hour)
                                            <div class="hour">
                                                <input type="checkbox" id="{{ $date }}-{{ $hour }}"
                                                    name="hours[]" value="{{ $date }}-{{ $hour }}"
                                                    class="hourCheckbox text-lime-500 focus:ring-lime-600">
                                                <label
                                                    for="{{ $date }}-{{ $hour }}">{{ $hour }}</label>
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
                            // Get all the radio buttons and hour checkboxes
                            var radios = document.querySelectorAll('input[type=radio][name="date"]');
                            var hourCheckboxes = document.querySelectorAll('.hourCheckbox');
                            var submitButton = document.getElementById('submitButton');

                            // Initially disable the submit button
                            submitButton.disabled = true;
                            submitButton.classList.add('cursor-not-allowed');

                            // Function to check if at least one hour checkbox is checked
                            function checkHourCheckboxes() {
                                var isChecked = Array.from(hourCheckboxes).some(function(checkbox) {
                                    return checkbox.checked;
                                });

                                // Enable or disable the submit button based on whether a checkbox is checked
                                submitButton.disabled = !isChecked;
                                if (isChecked) {
                                    submitButton.classList.remove('cursor-not-allowed');
                                    submitButton.classList.add('cursor-pointer');
                                } else {
                                    submitButton.classList.add('cursor-not-allowed');
                                    submitButton.classList.remove('cursor-pointer');
                                }
                            }

                            // Add a change event listener to each radio button
                            radios.forEach(function(radio) {
                                radio.addEventListener('change', function() {
                                    // Hide all the day divs
                                    document.querySelectorAll('.day').forEach(function(dayDiv) {
                                        dayDiv.style.display = 'none';
                                    });

                                    // Show the selected day div
                                    var selectedDayDiv = document.querySelector('.day[id="' + this.value + '"]');
                                    if (selectedDayDiv) {
                                        selectedDayDiv.style.display = 'block';
                                    }

                                    // Check the hour checkboxes whenever a date is selected
                                    checkHourCheckboxes();
                                });
                            });

                            // Add a change event listener to each hour checkbox
                            hourCheckboxes.forEach(function(checkbox) {
                                checkbox.addEventListener('change', checkHourCheckboxes);
                            });
                        </script>
                    </section>
                    <section class='p-6 bg-neutral-700'>
                        <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">A propos</h3>
                        <div>{{ $coach->bio }}</div>
                    </section>
                    <section class="p-6 bg-neutral-700">
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
