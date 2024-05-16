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
        // Check if the user is logged in
        if (!Auth::check()) {
            // Store the form data in the session
            $request->session()->put('form_data', $request->all());

            // Redirect to the login page
            return redirect()->route('login');
        }

        // Retrieve the form data from the session if it exists
        $form_data = $request->session()->get('form_data', $request->all());

        $validatedData = $request->validate([
            'date' => 'required|date',
            'start' => 'required|string', // Change 'hours' to 'start'
        ]);

        $user = Auth::user();

        /*
        // Check if the selected date and hours are still available
        foreach ($validatedData['hours'] as $hour) {
            list($day, $time) = explode('-', $hour);
            $availability = Availability::where('day_of_week', $day)
                ->whereTime('start_time', '<=', $time)
                ->whereTime('end_time', '>=', $time)
                ->first();

            if (!$availability) {
                // return back()->withErrors(['The selected date and time are no longer available.']);
                return back()->withErrors(['La date et le temps sélectionnés ne sont plus disponibles. Veuillez effectuer un choix à nouveau.']);
            }

            // Check if the selected date and hours already exist in the appointments table
            $existingAppointment = Appointment::where('date', $validatedData['date'])
                ->where('hours', 'like', '%' . $hour . '%')
                ->first();

            if ($existingAppointment) {
                // return back()->withErrors(['The selected date and time are already booked.']);
                return back()->withErrors(["La date et le temps sélectionnés viennent d'être réservés entre-temps. Veuillez effectuer un choix à nouveau."]);
            }
        }
 */

        // Check if the selected date and start time already exist in the appointments table
        $existingAppointment = Appointment::where('date', $validatedData['date'])
            ->where('start', $validatedData['start'])
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(["La date et le temps sélectionnés viennent d'être réservés entre-temps. Veuillez effectuer un choix à nouveau."]);
        }

        $appointment = new Appointment;
        $appointment->date = $validatedData['date'];
        $appointment->start = $validatedData['start']; // Change 'hours' to 'start'
        $appointment->user_id = $user->id;
        $appointment->save();

        // Remove the form data from the session
        $request->session()->forget('form_data');

        return redirect()->route('dashboard.index')->with('success', 'Le rendez-vous a été pris avec succès.');
        // return redirect()->route('appointments.index')->with('success', 'Appointment has been created successfully.');
    }
}
