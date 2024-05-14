<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'hours' => 'required|array',
            'hours.*' => 'required|string',
        ]);

        // Get the logged-in user
        $user = Auth::user();

        // Check if the selected date and hours are still available
        foreach ($validatedData['hours'] as $hour) {
            list($day, $time) = explode('-', $hour);
            $availability = Availability::where('day_of_week', $day)
                ->whereTime('start_time', '<=', $time)
                ->whereTime('end_time', '>=', $time)
                ->first();

            if (!$availability) {
                // return back()->withErrors(['The selected date and time are no longer available.']);
                return back()->withErrors(['La date sélectionnée et le temps ne sont plus disponibles.']);
            }
        }

        $appointment = new Appointment;
        $appointment->date = $validatedData['date'];
        $appointment->hours = $validatedData['hours'];
        $appointment->user_id = $user->id; // Associate the appointment with the logged-in user
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Le rendez-vous a été pris avec succès.');
        // return redirect()->route('appointments.index')->with('success', 'Appointment has been created successfully.');
    }
}
