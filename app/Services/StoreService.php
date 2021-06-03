<?php


namespace App\Services;


use App\Models\Item;
use Illuminate\Routing\Route;

class StoreService
{
    public function index()
    {

    }


    public function store($data)
    {
        $item = Item::create([
            'name' => $data['name'],
            'price' => $data['price']
        ]);

        return isset($item)
            ? response()->json(['result' => 'successful', 'url' => \route('item.show', $item->id)])
            : response()->json(['result' => 'not successful']);
    }

    /** updates the result and returns the result
     * @param Item $item
     * @param mixed $data
     * @return array|string
     */
    public function update(Item $item ,$data)
    {
        $item->price = $data['price'];
        $item->name = $data['name'];

        return $item->update() ? ['url' => \route('item.update', $item->id)]
            : 'failed';
    }
}
