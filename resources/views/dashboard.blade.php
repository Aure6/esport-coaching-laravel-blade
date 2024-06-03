<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div x-data="{ tab: localStorage.getItem('tab') || 'tab1' }" x-init="$watch('tab', val => localStorage.setItem('tab', val))" class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-6 mx-auto overflow-hidden text-white bg-green-500 sm:rounded-xl" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div class="p-6 mx-auto overflow-hidden text-white bg-blue-500 sm:rounded-xl" role="info">
                    {{ session('info') }}
                </div>
            @endif
            <div class="flex flex-wrap p-2 text-sm font-medium text-center text-gray-400 sm:rounded-xl bg-neutral-800">
                <button :class="{ 'bg-lime-500 text-neutral-900': tab === 'tab1' }"
                    class="inline-block p-4 duration-200 rounded-lg hover:bg-neutral-700 hover:text-neutral-200"
                    @click="tab = 'tab1'">Rendez-vous</button>
                @if (Auth::user()->role->name === 'Coach')
                    <button :class="{ 'bg-lime-500 text-neutral-900': tab === 'tab2' }"
                        class="px-4 py-2 duration-200 rounded-lg hover:bg-neutral-700 hover:text-neutral-200"
                        @click="tab = 'tab2'">Disponibilités</button>
                @endif
                <button :class="{ 'bg-lime-500 text-neutral-900': tab === 'tab3' }"
                    class="p-4 duration-200 rounded-lg hover:bg-neutral-700 hover:text-neutral-200"
                    @click="tab = 'tab3'">Rôle</button>
                @if (Auth::user()->role->name === 'Coach')
                    <button :class="{ 'bg-lime-500 text-neutral-900': tab === 'tab4' }"
                        class="px-4 py-2 duration-200 rounded-lg hover:bg-neutral-700 hover:text-neutral-200"
                        @click="tab = 'tab4'">Jeu</button>
                @endif
                <button :class="{ 'bg-lime-500 text-neutral-900': tab === 'tabBio' }"
                    class="px-4 py-2 duration-200 rounded-lg hover:bg-neutral-700 hover:text-neutral-200"
                    @click="tab = 'tabBio'">Bio</button>
            </div>

            {{-- <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            <div x-cloak x-show="tab === 'tab3'"
                class="max-w-3xl p-6 mx-auto overflow-hidden shadow-sm bg-neutral-800 sm:rounded-lg">
                <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Rôle</h3>
                @if (is_null(Auth::user()->role_id))
                    <div>Vous n'avez actuellement aucun rôle. Vous pouvez choisir un rôle.</div>
                @else
                    <div>
                        Vous êtes <span class="font-semibold">{{ strtolower(Auth::user()->role->name) }}</span> mais
                        vous pouvez changez à tout moment de rôle. Gardez en tête que vous resterez
                        <span class="font-semibold">{{ strtolower(Auth::user()->role->name) }}</span>
                        pour les rendez-vous déjà planifiés avant votre changement de rôle.
                    </div>
                @endif
                <form method="POST" action="{{ route('user.updateRole') }}">
                    @csrf
                    <div class="">
                        <input type="radio" id="client" name="role_id" value="2" class="hidden peer" required
                            {{ Auth::user()->role->name === 'Client' ? 'checked' : '' }} />
                        <label for="client"
                            class="inline-flex items-center justify-between p-2 border rounded-full cursor-pointer border-neutral-700 text-neutral-400 bg-neutral-800 peer-checked:text-lime-300 peer-checked:bg-neutral-700 peer-checked:border peer-checked:border-lime-500 hover:text-neutral-300 hover:bg-neutral-700">
                            <div class="block">
                                <div class="w-full">{{ __('Client') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="">
                        <input type="radio" id="coach" name="role_id" value="1" class="hidden peer" required
                            {{ Auth::user()->role->name === 'Coach' ? 'checked' : '' }} />
                        <label for="coach"
                            class="inline-flex items-center justify-between p-2 border rounded-full cursor-pointer border-neutral-700 text-neutral-400 bg-neutral-800 peer-checked:text-lime-300 peer-checked:bg-neutral-700 peer-checked:border peer-checked:border-lime-500 hover:text-neutral-300 hover:bg-neutral-700">
                            <div class="block">
                                <div class="w-full">{{ __('Coach') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-center mt-8">
                        <x-primary-button id="submitButton" type="submit" class="cursor-pointer">
                            {{-- {{ __('Update Role') }} --}}
                            {{ __('Mettre à jour le rôle') }}
                        </x-primary-button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const currentRoleId = {{ Auth::user()->role_id }};
                        const radioButtons = document.querySelectorAll('input[name="role_id"]');
                        const submitButton = document.getElementById('submitButton');

                        function updateButtonState() {
                            let isChecked = false;
                            radioButtons.forEach(radio => {
                                if (radio.checked && parseInt(radio.value) !== currentRoleId) {
                                    isChecked = true;
                                }
                            });

                            submitButton.disabled = !isChecked;
                            if (isChecked) {
                                submitButton.classList.remove('cursor-not-allowed', 'bg-lime-200', 'hover:bg-lime-200',
                                    'hover:text-black');
                                submitButton.classList.add('cursor-pointer', 'hover:text-white');
                            } else {
                                submitButton.classList.add('cursor-not-allowed', 'bg-lime-200', 'hover:bg-lime-200',
                                    'hover:text-black');
                                submitButton.classList.remove('cursor-pointer', 'hover:text-white');
                            }
                        }

                        radioButtons.forEach(radio => {
                            radio.addEventListener('change', updateButtonState);
                        });

                        updateButtonState(); // Initialize state on page load
                    });
                </script>
            </div>

            <div x-cloak x-show="tab === 'tab1'"
                class="p-6 mx-auto overflow-hidden shadow-sm bg-neutral-800 sm:rounded-lg">
                <x-section-title>Rendez-vous</x-section-title>

                <div class="card-body">
                    @if ($appointments->isEmpty())
                        <p>No appointments found.</p>
                    @else
                        <ul class="space-y-1">
                            @foreach ($appointments as $appointment)
                                <li
                                    class="sm:grid grid-flow-col auto-cols-fr hover:bg-neutral-600 divide-gray-200 > *  bg-neutral-700 sm:rounded-lg">
                                    {{-- <td class="p-1">
                                            @if (Auth::user()->role->name === 'Coach')
                                                {{ $appointment->client->name }}
                                            @else
                                                {{ $appointment->coach->name }}
                                            @endif
                                        </td> --}}
                                    <div class="px-1 py-2">
                                        <div class="p-1">Coach: {{ $appointment->coach->name }}</div>
                                        <div class="p-1">Joueur: {{ $appointment->client->name }}</div>
                                    </div>
                                    <div class="flex items-center justify-center p-1">
                                        <div class="">
                                            {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                                            {{ \Carbon\Carbon::parse($appointment->start)->format('H:i') }}<br>
                                            {{ \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->start)->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center p-1">
                                        <div class="">Planifié le
                                            {{ $appointment->updated_at->format('d-m-Y') }}
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center p-1">
                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-appointment-deletion')"
                                            class="m-auto text-red-500 transition-all duration-200 rounded hover:ring-red-500 hover:ring-2 hover:text-white hover:bg-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="inline-block w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Annuler
                                        </button>
                                    </div>
                                </li>
                                <!-- Modal -->
                                <x-modal name="confirm-appointment-deletion" :show="$errors->appointmentDeletion->isNotEmpty()"
                                    @open-modal.window="if ($event.detail === 'confirm-appointment-deletion') show = true"
                                    @close-modal.window="if ($event.detail === 'confirm-appointment-deletion') show = false"
                                    focusable>
                                    <form method="post"
                                        action="{{ route('appointments.destroy', ['id' => $appointment->id]) }}"
                                        class="p-6">
                                        @csrf
                                        @method('delete')

                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Are you sure you want to delete this appointment?') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Once this appointment is deleted, all of its data will be permanently deleted.') }}
                                        </p>

                                        <div class="flex justify-end mt-6">
                                            <x-secondary-button
                                                x-on:click="$dispatch('close-modal', 'confirm-appointment-deletion')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Appointment') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            @if (Auth::user()->role->name == 'Coach')
                <div x-cloak x-show="tab === 'tab2'"
                    class="flex flex-col items-center justify-center max-w-sm p-6 mx-auto overflow-hidden shadow-sm sm:w-fit bg-neutral-800 sm:rounded-lg">
                    <x-section-title class="self-start">Disponibilités</x-section-title>
                    <div class="self-start">
                        Une session dure une heure.
                    </div>
                    <form method="POST" action="{{ route('availabilities.update') }}" class="">
                        @csrf
                        @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                            @php
                                $availability = $availabilities->firstWhere('day_of_week', $day);
                            @endphp
                            <div x-data="{ available: {{ $availability ? 'true' : 'false' }} }"
                                class="p-2 mx-auto my-2 rounded-lg bg-neutral-700 availability-day w-fit">
                                <div>
                                    <input x-bind:checked="available" x-on:click="available = !available"
                                        type="checkbox" id="{{ strtolower($day) }}_checkbox"
                                        name="{{ strtolower($day) }}_checkbox" {{ $availability ? 'checked' : '' }}
                                        class=" text-lime-500">
                                    <label for="{{ strtolower($day) }}_checkbox"
                                        class="text-lg font-semibold text-lime-500">{{ $day }}</label>
                                </div>
                                <label for="{{ strtolower($day) }}_start">De</label>
                                <select id="{{ strtolower($day) }}_start" name="{{ strtolower($day) }}_start"
                                    x-bind:disabled="!available"
                                    class="text-sm text-white rounded-lg placeholder-neutral-400 bg-neutral-700 border-neutral-600 focus:ring-lime-500 focus:border-lime-500">
                                    @for ($i = 0; $i < 24; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}:00"
                                            {{ ($availability && substr($availability->start_time, 0, 2) == sprintf('%02d', $i)) || (!$availability && $i == 9) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}:00</option>
                                    @endfor
                                </select>
                                {{-- <span>-></span> --}}
                                <label for="{{ strtolower($day) }}_end">à</label>
                                <select id="{{ strtolower($day) }}_end" name="{{ strtolower($day) }}_end"
                                    x-bind:disabled="!available"
                                    class="text-sm text-white rounded-lg placeholder-neutral-400 bg-neutral-700 border-neutral-600 focus:ring-lime-500 focus:border-lime-500">
                                    @for ($i = 0; $i < 24; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}:00"
                                            {{ ($availability && substr($availability->end_time, 0, 2) == sprintf('%02d', $i)) || (!$availability && $i == 12) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}:00</option>
                                    @endfor
                                </select>
                            </div>
                        @endforeach
                        <div class="flex justify-center">
                            <x-primary-button type="submit">Enregistrer les disponibilités</x-primary-button>
                        </div>
                    </form>
                </div>
            @endif

            @if (Auth::user()->role->name === 'Coach')
                <div x-cloak x-show="tab === 'tab4'"
                    class="max-w-3xl p-6 mx-auto overflow-hidden shadow-sm bg-neutral-800 sm:rounded-lg">
                    <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Jeu</h3>
                    @if (is_null(Auth::user()->game_id))
                        <div>Vous n'avez actuellement aucun jeu. Vous pouvez choisir un jeu.</div>
                    @else
                        <div>
                            Vous avez actuellement sélectionné le jeu <span
                                class="font-semibold">{{ Auth::user()->game->name }}</span>.
                        </div>
                    @endif
                    <form method="POST" action="{{ route('user.updateGame') }}">
                        @csrf
                        <div class="mt-4">
                            <label for="game_id" class="block text-sm font-medium text-neutral-400">Sélectionnez un
                                jeu</label>
                            <select id="game_id" name="game_id"
                                class="block w-full mt-1 border bg-neutral-800 border-neutral-700">
                                @foreach ($games as $game)
                                    <option value="{{ $game->id }}"
                                        {{ Auth::user()->game_id == $game->id ? 'selected' : '' }}>
                                        {{ $game->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-center mt-8">
                            <x-primary-button id="submitButton" type="submit" class="cursor-pointer">
                                {{ __('Mettre à jour le jeu') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            @endif

            <div x-cloak x-show="tab === 'tabBio'"
                class="max-w-3xl p-6 mx-auto overflow-hidden shadow-sm bg-neutral-800 sm:rounded-lg">
                <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Modifier bio</h3>
                <form method="POST" action="{{ route('user.updateBio') }}">
                    @csrf
                    <div class="mt-4">
                        <label for="bio" class="block text-sm font-medium text-neutral-400">Votre bio</label>
                        <textarea id="bio" name="bio" class="block w-full mt-1 border bg-neutral-800 border-neutral-700"
                            rows="15">{{ Auth::user()->bio }}</textarea>
                    </div>
                    <div class="flex items-center justify-center mt-8">
                        <x-primary-button id="submitButton" type="submit" class="cursor-pointer">
                            {{ __('Mettre à jour la bio') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
