<?php


namespace App\Services;


use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    /**
     * @param string $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($sort = name, $order)
    {
        if($order === 'desc') {
            $items = Item::paginate(15)->sortByDesc($sort)->all();
        } else {
            $items = Item::paginate(15)->sortBy($sort)->all();
        }

        return response()->json(['items' => array_values($items)]);
    }


    public function store($data, $image)
    {
        $imageUrl = Storage::disk('public')->url('default-images/default.png');
        if($image) {
            $imagePath = $image->store('store-images', 'public');
            $imageUrl = Storage::disk('public')->url($imagePath);
        }

        $item = Item::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $imageUrl,
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
