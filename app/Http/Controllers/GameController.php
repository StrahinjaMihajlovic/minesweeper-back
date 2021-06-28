<?php

namespace App\Http\Controllers;


use App\Services\Game_services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {

    }

    public function generateGame()
    {
        return response()->json($this->gameService->generateGame(4, 4));
    }
}
