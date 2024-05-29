<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $coaches = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->inRandomOrder()->take(5)->get();

        return view('welcome', [
            'coaches' => $coaches,
        ]);
    }
}
