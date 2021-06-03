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
            ? response()->json(['result' => 'successful', 'url' => \route('item.show', $data['name'])])
            : response()->json(['result' => 'not successful']);
    }

    /** updates the result and returns the result
     * @param $name
     * @return bool
     */
    public function update(Item $item ,$data)
    {
        $item->price = $data['price'];

        if($item->name !== $data['name']){
            $newItem = $item->replicate(['name', 'updated_at']);
            $newItem->name = $data['name'];
            $item->delete();
            $newItem->save();
            return \route('item.update', $newItem->name);
        }

        return $item->update();
    }
}
