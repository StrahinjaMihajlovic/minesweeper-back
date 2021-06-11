<?php


namespace App\Services;


use App\Models\Item;

class StoreService
{
    /**
     * @param string $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($sort = name)
    {
        $items = Item::paginate(15)->sortBy($sort)->all();
        return response()->json(['items' => array_values($items)]);
    }


    public function store($data)
    {
        $item = Item::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description']
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
        $item->fill($data);
        return $item->update() ? ['url' => \route('item.update', $item->id)]
            : 'failed';
    }
}
