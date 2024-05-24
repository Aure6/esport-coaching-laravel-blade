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
        // dd($request);
        $validatedData = $request->validate([
            'date' => 'required|date',
            'hours' => 'required|array',
            'hours.*' => 'required|string',
        ]);

        // Extract the date and hours from the request
        $date = $request->input('date');
        $hours = $request->input('hours');

        // Get the coach_id from the route parameters
        $coach_id = $request->route('coach_id');

        // Get the client_id from the authenticated user
        $client_id = auth()->id();

        foreach ($hours as $hour) {
            // Extract the date and hour using substr
            $date = substr($hour, 0, 10); // Get the first 10 characters for the date
            $hour = substr($hour, 11); // Get the rest of the string for the hour

            // Check if the hour is in the correct format
            if (preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $hour)) {
                // Create a new appointment
                $appointment = new Appointment();
                $appointment->client_id = $client_id;
                $appointment->coach_id = $coach_id;
                $appointment->date = $date;
                $appointment->start = $hour;

                // Save the appointment
                $appointment->save();
            } else {
                // Handle the case where the hour is not in the correct format
                // This could be returning an error message, throwing an exception, etc.
                dd();
            }
        }

        return redirect()->back()->with('success', 'Le rendez-vous a été pris avec succès. Vous pouvez voir vos rendez-vous sur votre tableau de bord.');
        // return redirect()->route('dashboard')->with('success', 'Appointment has been created successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        // return redirect()->back()->with('success', 'Appointment deleted successfully');
        return redirect()->back()->with('success', 'Rendez-vous supprimé avec succès');
    }
}
