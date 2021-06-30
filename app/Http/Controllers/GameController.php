<?php

namespace App\Http\Controllers;


use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Models\Game;
use App\Services\Game_services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /** returns field resources for the FE
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function play(Game $game)
    {
        return response()->json([
            'fields' => array_values(FieldResource::collection($game->fields->sortBy('field_number'))->collection->all())
            ,'size' => "$game->size_x" . "x" . "$game->size_y"]);
    }


    public function generateGame()
    {
        return response()->json($this->gameService->generateGame(5, 5));
    }

    /** TODO create and implement request class for this function
     * @param Field $field
     */
    public function openField(Field $field)
    {
        $this->gameService->openField($field);
    }

    public function listGames()
    {
        //TODO filter the games by not owned and sorting by finished/unfinished
        return Game::all();
    }
}
