<?php

namespace App\Transformers;

use App\Models\Item;
use League\Fractal\TransformerAbstract;
class ItemTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Item $item)
    {
        return [
            'name' => $item->name,
            'price' => $item->price,
            'description' => $item->description,
            'id' => $item->id,
            'image' => $item->image
        ];
    }
}
