<?php

namespace App\Http\Controllers;


use App\Models\Game;
use App\Services\Game_services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function play(Game $game)
    {
        return response()->json(['fields' => $game->fields]);
    }

    public function generateGame()
    {
        return response()->json($this->gameService->generateGame(5, 5));
    }
}
