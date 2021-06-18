<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCreationRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\StoreIndexRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Item;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    protected $storeService;
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    //returns data for index page

    /**
     * @param StoreIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(StoreIndexRequest $request)
    {
        return $this->storeService->index($request->query('sort', 'name'),
            $request->query('order'), $request->query('category', false));
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
        $image = $request->hasFile('image') ? $request->file('image') : false;
        return $this->storeService->store($request->only(['name', 'price', 'description', 'category']), $image);
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
    //updates the items

    /**
     * @param ItemUpdateRequest $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ItemUpdateRequest $request, Item $item)
    {
        return response()->json(['result' => $this->storeService->update($item, $request->only(['name', 'price', 'description']))]);
    }

    /** creates a category for items
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCategory(Request $request) {
        $request->validate([
            'name' => ['string', 'required', 'unique:Category']
        ]);

        return $this->storeService->createCategory($request->input('name'));
    }

    public function sellItem(Item $item)
    {
        return $this->storeService->transaction($item);
    }

    /** Returns all categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCategories() {
        return response()->json(CategoryResource::collection(Category::all()));
    }
}
