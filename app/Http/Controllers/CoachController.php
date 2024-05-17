<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // the for loop calculates dates for the 8 next weeks
        for ($i = 0; $i < 8 * 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $dayOfWeek = $date->format('l');

            // Check if the coach has availability on this day
            if ($coachAvailabilities->contains('day_of_week', $dayOfWeek)) {
                foreach ($coachAvailabilities as $availability) {
                    if ($availability->day_of_week == $dayOfWeek) {
                        $start = Carbon::parse($availability->start_time);
                        $end = Carbon::parse($availability->end_time);
                        $interval = 60; // Interval in minutes

                        while ($start->lessThan($end)) {
                            // Check if there is an appointment with the same coach, the same start time, and the same date
                            $appointmentExists = DB::table('appointments')
                                ->where('coach_id', $coach->id)
                                ->where('start', $start->format('H:i:s'))
                                ->whereDate('date', $date->format('Y-m-d'))
                                ->exists();

                            if (!$appointmentExists) {
                                $availabilities[$date->format('Y-m-d')][$start->format('H:i')] = $start->format('H:i');
                            }

                            $start->addMinutes($interval);
                        }
                    }
                }
            }
        }

        dd($availabilities);

        return view('coaches.show', [
            'coach' => $coach,
            'availabilities' => $availabilities,
        ]);
    }
}
