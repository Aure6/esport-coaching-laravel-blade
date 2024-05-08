<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function show($id)
    {
        $coach = User::findOrFail($id);

        return view('coaches.show', [
            'coach' => $coach,
        ]);
    }
}
