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
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="card-header">Appointments</div>

                <div class="card-body">
                    @if ($appointments->isEmpty())
                        <p>No appointments found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Client/Coach</th>
                                    <th>Date</th>
                                    <th>Hours</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>
                                            @if (Auth::user()->role_id == 'coach')
                                                {{ $appointment->client->name }}
                                            @else
                                                {{ $appointment->coach->name }}
                                            @endif
                                        </td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ implode(', ', $appointment->hours) }}</td>
                                        <td>{{ $appointment->created_at->format('d-m-Y H:i') }}</td>
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
