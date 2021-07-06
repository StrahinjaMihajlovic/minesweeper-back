<?php

namespace App\Http\Resources;

use App\Models\Field;
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
            'field_number' => $this->field_number_display,
            'id' => $this->id,
            'contains' => $this->isOpened() ? $this->contains : 'not visited'
        ];
    }

    /** tests if the fields is opened or not
     * @return mixed
     */
    protected function isOpened()
    {
        return auth()->user()->didPlayerOpenTheField(Field::find($this->id));
    }
}
