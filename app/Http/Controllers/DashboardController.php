<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $appointments = Appointment::where('client_id', $user->id)
            ->orWhere('coach_id', $user->id)
            ->get();

        return view('dashboard', compact('appointments'));
    }
}
