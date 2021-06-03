<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCreationRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use App\Services\StoreService;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    protected $storeService;
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    //returns data for index page
    public function index()
    {

    }

    //displays single item

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return response()->json($item->attributesToArray());
    }

    //creates a new item

    /**
     * @param ItemCreationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ItemCreationRequest $request)
    {
        return $this->storeService->store($request->only(['name', 'price']));
    }

    // destroys an item and returs result of the action

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item)
    {
        return response()->json(['result' => $item->delete()]);
    }

    public function update(ItemUpdateRequest $request, Item $item)
    {
        return response()->json(['result' => $this->storeService->update($item, $request->input())]);
    }
}
