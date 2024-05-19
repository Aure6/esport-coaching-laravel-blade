<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="mx-auto overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <h3 class="text-xl uppercase text-lime-500 card-header">Appointments</h3>

                <div class="card-body">
                    @if ($appointments->isEmpty())
                        <p>No appointments found.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Utilisateurs
                                        {{-- @if (Auth::user()->role_id == 'coach')
                                            {{ Clients }}
                                        @else
                                            {{ Coach }}
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
                                            @if (Auth::user()->role_id == 'coach')
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
        </div>
    </div>
</x-app-layout>
