<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'field_number' => $this->field_number,
            'id' => $this->id,
            'contains' => $this->is_open ? $this->contains : 'not visited'
        ];
    }
}
