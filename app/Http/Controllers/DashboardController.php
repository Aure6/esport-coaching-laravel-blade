<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $now = Carbon::now();
        $appointments = Appointment::where('client_id', $user->id)
            ->orWhere('coach_id', $user->id)
            ->where('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->get();

        if ($user->role->name === "Coach") {
            $availabilities = Availability::where('coach_id', $user->id)->get();
            // dd($availabilities);
            return view('dashboard', compact('appointments', 'availabilities'));
        }

        return view('dashboard', compact('appointments'));
    }

    public function updateRole(Request $request)
    {
        // Validate the request...
        $request->validate([
            'role_id' => 'required|in:2,1', // replace 'client' and 'coach' with actual role IDs
        ]);

        // Get the authenticated user...
        $user = Auth::user();

        // Update the user's role...
        $user->role_id = $request->role_id;
        // dd($request);
        $user->save();
        // dd($request);

        // Redirect the user...
        // return redirect()->route('dashboard')->with('status', 'Role updated successfully!');
        return redirect()->route('dashboard')->with('status', 'Rôle mis à jour avec succès!');
    }
}
