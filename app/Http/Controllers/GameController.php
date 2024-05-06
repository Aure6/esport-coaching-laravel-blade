<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('name')->get();

        return view('games.index', [
            'games' => $games,
        ]);
    }
    public function show($id)
    {
        $game = Game::findOrFail($id);

        $coaches = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->where('game_id', '=', $id)->get();

        // dd($coaches);

        return view('games.show', [
            'coaches' => $coaches,
            'game' => $game,
        ]);
    }
}
