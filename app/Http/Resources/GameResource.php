<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            //'owner' => $this->owner,
            'size_x' => $this->size_x,
            'size_y' => $this->size_y,
            'user_played' => $this->hasUserPlayedThisGame()
        ];
    }
}
