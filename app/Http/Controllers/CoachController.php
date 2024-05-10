<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function show($id)
    {
        $coach = User::findOrFail($id);

        foreach ($coach->reviews as $review) {
            $review->client_name = $review->client->name;
        }

        $coach->created_at_date = $coach->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, false);

        $availabilities = [];
        $coachAvailabilities = Availability::where('coach_id', $coach->id)->get();
        foreach ($coachAvailabilities as $availability) {
            $start = Carbon::parse($availability->start_time);
            $end = Carbon::parse($availability->end_time);
            $interval = 60; // Interval in minutes

            while ($start->lessThan($end)) {
                $availabilities[$availability->day_of_week][] = $start->format('H:i');
                $start->addMinutes($interval);
            }
            // while ($start->lessThan($end)) {
            //     $timeSlot = $start->format('H:i');
            //     if (!isset($availabilities[$availability->day_of_week][$timeSlot])) {
            //         $availabilities[$availability->day_of_week][$timeSlot] = $timeSlot;
            //     }
            //     $start->addMinutes($interval);
            // }
        }

        // Calculate the dates for the next 8 weeks
        $dates = collect();
        for ($i = 0; $i < 8 * 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $dayOfWeek = $date->format('l');

            // Check if the coach has availability on this day
            if ($coachAvailabilities->contains('day_of_week', $dayOfWeek)) {
                $dates->push($date->format('Y-m-d'));
            }
        }

        return view('coaches.show', [
            'coach' => $coach,
            'availabilities' => $availabilities,
            'dates' => $dates,
        ]);
    }
}
