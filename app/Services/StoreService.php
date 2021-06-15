<?php


namespace App\Services;


use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    // declare the number of items you want to get per page (pagination)
    public $itemsPerPage = 6;
    /**
     * @param string $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($sort = name, $order)
    {
        if($order === 'desc') {
            $items = Item::paginate($this->itemsPerPage)->sortByDesc($sort)->all();
        } else {
            $items = Item::paginate($this->itemsPerPage)->sortBy($sort)->all();
        }
        // returns items per page and how much pages there is for given parameters
        return response()->json(['items' => array_values($items), 'pages' => $this->pages()]);
    }

    public function pages()
    {
        return ceil(Item::all()->count() / $this->itemsPerPage);
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
