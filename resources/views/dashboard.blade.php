<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div x-data="{ tab: localStorage.getItem('tab') || 'tab1' }" x-init="$watch('tab', val => localStorage.setItem('tab', val))" class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-6 mx-auto overflow-hidden text-white bg-green-500 sm:rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex">
                <button :class="{ 'bg-lime-500 text-white': tab === 'tab1' }" class="px-4 py-2 hover:bg-lime-400"
                    @click="tab = 'tab1'">Rendez-vous</button>
                <button :class="{ 'bg-lime-500 text-white': tab === 'tab2' }" class="px-4 py-2 hover:bg-lime-400"
                    @click="tab = 'tab2'">Disponibilités</button>
                <button :class="{ 'bg-lime-500 text-white': tab === 'tab3' }" class="px-4 py-2 hover:bg-lime-400"
                    @click="tab = 'tab3'">Rôle</button>
            </div>

            {{-- <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            <div x-show="tab === 'tab3'" class="p-6 mx-auto overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Rôle</h3>
                <form method="POST" action="{{ route('user.updateRole') }}">
                    @csrf
                    <div>Vous êtes <span class="font-semibold">{{ strtolower(Auth::user()->role->name) }}</span> mais
                        vous pouvez
                        changez à tout moment de rôle. Gardez
                        en tête que vous resterez <span
                            class="font-semibold">{{ strtolower(Auth::user()->role->name) }}</span> pour
                        les rendez-vous déjà planifiés
                        avant votre changement de rôle.
                    </div>
                    <div class="">
                        <input type="radio" id="client" name="role_id" value="2" class="hidden peer"
                            required />
                        <label for="client"
                            class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-lime-500 dark:peer-checked:bg-gray-700 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="block">
                                <div class="w-full">{{ __('Client') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="mb-4">
                        <input type="radio" id="coach" name="role_id" value="1" class="hidden peer"
                            required />
                        <label for="coach"
                            class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-lime-500 dark:peer-checked:bg-gray-700 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="block">
                                <div class="w-full">{{ __('Coach') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button type="submit">
                            {{-- {{ __('Update Role') }} --}}
                            {{ __('Mettre à jour le rôle') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div x-show="tab === 'tab1'" class="p-6 mx-auto overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <h3 class="text-2xl font-semibold leading-tight uppercase text-lime-500">Rendez-vous</h3>

                <div class="card-body">
                    @if ($appointments->isEmpty())
                        <p>No appointments found.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Utilisateurs
                                        {{-- @if (Auth::user()->role->name == 'coach')
                                            Client
                                        @else
                                            Coach
                                        @endif --}}
                                    </th>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th></th>
                                    <th>Planifié le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr class="border hover:bg-gray-200 even:bg-gray-100 odd:bg-white">
                                        <td class="p-1">
                                            @if (Auth::user()->role->name == 'coach')
                                                {{ $appointment->client->name }}
                                            @else
                                                {{ $appointment->coach->name }}
                                            @endif
                                        </td>
                                        <td class="p-1">{{ $appointment->date }}</td>
                                        <td class="p-1">
                                            {{ \Carbon\Carbon::parse($appointment->start)->format('H:i') }}</td>
                                        <td class="p-1">
                                            {{ \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->start)->diffForHumans() }}
                                        </td>
                                        <td class="p-1">{{ $appointment->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div x-show="tab === 'tab2'" class="p-6 mx-auto overflow-hidden bg-gray-600 shadow-sm sm:rounded-lg">
                <div>
                    Un service dure une heure.
                </div>
                <form method="POST" action="{{ route('availabilities.update') }}">
                    @csrf
                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                        @php
                            $availability = $availabilities->firstWhere('day_of_week', $day);
                        @endphp
                        <div x-data="{ available: {{ $availability ? 'true' : 'false' }} }" class="p-2 my-2 bg-gray-500 availability-day">
                            <h4 class="font-semibold text-lime-500">{{ $day }}</h4>
                            <input x-bind:checked="available" x-on:click="available = !available" type="checkbox"
                                id="{{ strtolower($day) }}_checkbox" name="{{ strtolower($day) }}_checkbox"
                                {{ $availability ? 'checked' : '' }} class=" text-lime-500">
                            <label for="{{ strtolower($day) }}_checkbox">Disponible</label>
                            <label for="{{ strtolower($day) }}_start">Heure de début:</label>
                            <select id="{{ strtolower($day) }}_start" name="{{ strtolower($day) }}_start"
                                x-bind:disabled="!available">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00"
                                        {{ $availability && substr($availability->start_time, 0, 2) == sprintf('%02d', $i) ? 'selected' : '' }}>
                                        {{ sprintf('%02d', $i) }}:00</option>
                                @endfor
                            </select>
                            <label for="{{ strtolower($day) }}_end">Heure de fin:</label>
                            <select id="{{ strtolower($day) }}_end" name="{{ strtolower($day) }}_end"
                                x-bind:disabled="!available">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00"
                                        {{ $availability && substr($availability->end_time, 0, 2) == sprintf('%02d', $i) ? 'selected' : '' }}>
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
        </div>
    </div>
</x-app-layout>
