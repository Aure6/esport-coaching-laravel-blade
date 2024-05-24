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
            }
        }




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


        // Check if the selected date and start time already exist in the appointments table
        // $existingAppointment = Appointment::where('date', $validatedData['date'])
        //     ->where('start', $validatedData['start'])
        //     ->where('coach_id', $validatedData['coach_id'])
        //     ->first();

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

        return redirect()->route('back')->with('success', 'Le rendez-vous a été pris avec succès. Vous pouvez voir vos rendez-vous sur votre tableau de bord.');
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
