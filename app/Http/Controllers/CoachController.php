<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        // dd($coach->reviews);

        return view('coaches.show', [
            'coach' => $coach,
        ]);
    }
}
