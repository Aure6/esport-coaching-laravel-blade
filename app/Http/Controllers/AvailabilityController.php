<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user(); // Get the currently authenticated user

        foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day) {
            if ($request->has(strtolower($day) . '_checkbox')) {
                $startTime = $request->input(strtolower($day) . '_start') . ':00';
                $endTime = $request->input(strtolower($day) . '_end') . ':00';

                // Update the availability if it exists, otherwise create a new one
                Availability::updateOrCreate(
                    ['coach_id' => $user->id, 'day_of_week' => $day],
                    ['start_time' => $startTime, 'end_time' => $endTime]
                );
            } else {
                // Delete the availability if it exists
                Availability::where('coach_id', $user->id)->where('day_of_week', $day)->delete();
            }
        }

        return redirect()->back()->with('success', 'Disponibilités mises à jour avec succès!');
    }
}
