<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day) {
            if ($request->has(strtolower($day) . '_checkbox')) {
                $startTime = $request->input(strtolower($day) . '_start') . ':00';
                $endTime = $request->input(strtolower($day) . '_end') . ':00';

                Availability::updateOrCreate(
                    ['coach_id' => $user->id, 'day_of_week' => $day],
                    ['start_time' => $startTime, 'end_time' => $endTime]
                );
            } else {
                Availability::where('coach_id', $user->id)->where('day_of_week', $day)->delete();
            }
        }

        return redirect()->back()->with('success', 'Disponibilités mises à jour avec succès!');
    }
}
