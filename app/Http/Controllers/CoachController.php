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

        $coach->date = $coach->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, false);

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

        return view('coaches.show', [
            'coach' => $coach,
            'availabilities' => $availabilities,
        ]);
    }
}
