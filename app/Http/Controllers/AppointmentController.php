<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hours' => 'required|array',
            'hours.*' => 'required|string',
        ]);

        $hours = $request->input('hours');

        $coach_id = $request->route('coach_id');

        $client_id = auth()->id();

        DB::beginTransaction();

        try {
            foreach ($hours as $hourEntry) {
                // Extract the date and hour from the hourEntry
                $date = substr($hourEntry, 0, 10); // Get the first 10 characters for the date
                $hour = substr($hourEntry, 11); // Get the rest of the string for the hour

                // Validate the hour format
                if (!preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $hour)) {
                    DB::rollBack();
                    return redirect()->back()->withErrors('L\'heure fournie n\'est pas dans le format correct.');
                }

                // Get the day of the week from the date
                $dayOfWeek = Carbon::parse($date)->format('l');

                // Check if the coach is available at the given date and hour
                $availability = DB::table('availabilities')
                    ->where('coach_id', $coach_id)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('start_time', '<=', $hour)
                    ->where('end_time', '>', $hour)
                    ->exists();

                if (!$availability) {
                    DB::rollBack();
                    return redirect()->back()->withErrors('Le coach n\'est pas disponible à cette heure.');
                }

                // Check if there is already an appointment at the given date and hour
                $existingAppointment = DB::table('appointments')
                    ->where('coach_id', $coach_id)
                    ->where('start', $hour . ':00') // Ensure matching format with the seeder
                    ->whereDate('date', $date)
                    ->exists();

                if ($existingAppointment) {
                    DB::rollBack();
                    return redirect()->back()->withErrors('Le coach a déjà un rendez-vous à cette heure.');
                }

                $appointment = new Appointment();
                $appointment->client_id = $client_id;
                $appointment->coach_id = $coach_id;
                $appointment->date = $date;
                $appointment->start = $hour . ':00'; // Ensure matching format with the seeder

                $appointment->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Le rendez-vous a été pris avec succès. Vous pouvez voir vos rendez-vous sur votre tableau de bord.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Une erreur est survenue lors de la prise de rendez-vous.');
        }
    }


    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        // return redirect()->back()->with('success', 'Appointment deleted successfully');
        return redirect()->back()->with('success', 'Rendez-vous supprimé avec succès');
    }
}
