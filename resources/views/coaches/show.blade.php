<x-guest-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold leading-tight text-gray-800 uppercase">
            {{ $coach->name }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 overflow-hidden md:grid-cols-3">
                <section
                    class="gap-4 p-6 space-y-8 text-lg text-white uppercase sm:rounded-xl md:col-span-1 bg-neutral-800 h-fit">
                    <div class="flex flex-row space-x-2">
                        <x-avatar class="w-20 h-20" :user="$coach" />
                        <div>
                            <div>{{ $coach->name }}</div>
                            <div class="inline-block p-1 text-sm">{{ $coach->game->name }}</div>
                        </div>
                    </div>
                    {{-- <div>Coach depuis {{ $coach->created_at->diffForHumans() }}</div> --}}
                    <div>Coach depuis {{ $coach->created_at_date }}</div>
                    <section>
                        <x-section-title
                            class="text-2xl font-semibold leading-tight uppercase text-lime-500">Succès</x-section-title>
                        <ul>
                            <li>1ère place tournoi 1v1</li>
                        </ul>
                    </section>
                    <section>
                        <x-section-title
                            class="text-2xl font-semibold leading-tight uppercase text-lime-500">Langues</x-section-title>
                        <div>Français</div>
                    </section>
                </section>
                <section class="gap-4 space-y-6 text-lg text-white md:col-span-2 ">
                    <section class="p-6 bg-neutral-800 sm:rounded-xl">
                        <x-section-title
                            class="text-2xl font-semibold leading-tight uppercase text-lime-500">Disponibilités</x-section-title>
                        @if ($errors->any())
                            <div class="bg-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('appointments.store', ['coach_id' => $coach->id]) }}"
                            class="">
                            @csrf

                            <div class="space-y-1 date-picker">
                                @if (!empty($availabilities))
                                    <label for="date">Sélectionne une date</label>
                                @endif


                                <ul>
                                    @php
                                        $weekNumber = 0;
                                        $currentMonthYear = '';
                                        $months = [
                                            'January' => 'janvier',
                                            'February' => 'février',
                                            'March' => 'mars',
                                            'April' => 'avril',
                                            'May' => 'mai',
                                            'June' => 'juin',
                                            'July' => 'juillet',
                                            'August' => 'août',
                                            'September' => 'septembre',
                                            'October' => 'octobre',
                                            'November' => 'novembre',
                                            'December' => 'décembre',
                                        ];
                                    @endphp
                                    @forelse ($availabilities as $date => $hours)
                                        @php
                                            $displayedDate = date('d-m', strtotime($date));
                                            $dayName = date('l', strtotime($date));
                                            $currentWeekNumber = \Carbon\Carbon::parse($date)->weekOfYear;
                                            $monthYear = ucfirst(
                                                $months[date('F', strtotime($date))] .
                                                    ' ' .
                                                    date('Y', strtotime($date)),
                                            );
                                        @endphp

                                        @if ($monthYear !== $currentMonthYear)
                                            @if ($currentMonthYear !== '')
                            </div> <!-- Close the previous week div -->
                            @endif
                            <div class="w-full text-xl font-bold text-center month-year-header">
                                {{ $monthYear }}
                            </div>
                            @php
                                $currentMonthYear = $monthYear;
                                $weekNumber = 0; // Reset week number for new month
                            @endphp
                            @endif

                            @if ($currentWeekNumber !== $weekNumber)
                                @if ($weekNumber !== 0)
            </div> <!-- Close the previous week div -->
            @endif
            <div class="flex flex-col sm:flex-row sm:justify-around"> <!-- Open a new week div -->
                @php
                    $weekNumber = $currentWeekNumber;
                @endphp
                @endif
                <li class="w-full">
                    <input type="radio" id="{{ $date }}" name="date" value="{{ $date }}"
                        class="hidden peer" required />
                    <label for="{{ $date }}"
                        class="inline-flex items-center justify-between w-full p-2 rounded-full cursor-pointer text-neutral-400 bg-neutral-800 peer-checked:text-lime-300 peer-checked:bg-neutral-700 peer-checked:border peer-checked:border-lime-500 hover:text-neutral-300 hover:bg-neutral-700">
                        <div class="block mx-auto">
                            {{-- <div class="w-full text-lg font-semibold">{{ $date }}</div> --}}
                            <div class="w-full">{{ substr(__('days.' . $dayName), 0, 3) }}
                                {{ $displayedDate }}</div>
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
                <div class="mt-6 day" id="{{ $date }}" style="display: none;">
                    {{-- <h4>{{ __('days.' . $day) }}</h4> --}}
                    <legend>Sélectionne un ou plusieurs slots d'heure pour le jour sélectionné</legend>

                    @if (empty($hours))
                        <p>No availability on this day.</p>
                    @else
                        <p>Durée d'un service: 1 heure.</p>
                        @foreach ($hours as $hour)
                            <div class="inline-block hour">
                                <input type="checkbox" id="{{ $date }}-{{ $hour }}" name="hours[]"
                                    value="{{ $date }}-{{ $hour }}"
                                    class="hidden hourCheckbox text-lime-500 focus:ring-lime-600 peer ">
                                <label for="{{ $date }}-{{ $hour }}"
                                    class="inline-flex items-center justify-between w-full p-2 rounded-full cursor-pointer text-neutral-400 bg-neutral-800 peer-checked:text-lime-300 peer-checked:bg-neutral-700 peer-checked:border peer-checked:border-lime-500 hover:text-neutral-300 hover:bg-neutral-700">{{ $hour }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach

            <div class="flex justify-center">
                <x-primary-button type="submit" id="submitButton" disabled
                    class="mt-2 cursor-not-allowed">Réserver</x-primary-button>
            </div>
            </form>


            <script>
                const radios = document.querySelectorAll('input[type=radio][name="date"]');
                const hourCheckboxes = document.querySelectorAll('.hourCheckbox');
                const submitButton = document.getElementById('submitButton');

                submitButton.disabled = true;
                submitButton.classList.add('cursor-not-allowed');

                function checkHourCheckboxes() {
                    var isChecked = Array.from(hourCheckboxes).some(function(checkbox) {
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
                }

                radios.forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        hourCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = false;
                        });

                        document.querySelectorAll('.day').forEach(function(dayDiv) {
                            dayDiv.style.display = 'none';
                        });

                        var selectedDayDiv = document.querySelector('.day[id="' + this.value + '"]');
                        if (selectedDayDiv) {
                            selectedDayDiv.style.display = 'block';
                        }

                        checkHourCheckboxes();
                    });
                });

                hourCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', checkHourCheckboxes);
                });
            </script>
            </section>
            <section class='p-6 bg-neutral-800 sm:rounded-xl'>
                <x-section-title class="text-2xl font-semibold leading-tight uppercase text-lime-500">A
                    propos</x-section-title>
                <div>{{ $coach->bio }}</div>
            </section>
            <section class="p-6 bg-neutral-800 sm:rounded-xl">
                <x-section-title
                    class="text-2xl font-semibold leading-tight uppercase text-lime-500">Avis</x-section-title>
                <ul class="space-y-4">
                    @foreach ($coach->reviews as $review)
                        <li class="text-white bg-neutral-800">
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
