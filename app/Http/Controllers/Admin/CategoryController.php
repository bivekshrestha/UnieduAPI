<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\CategoryCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends BaseController
{

    protected $itemRepository;

    /**
     * CategoryController constructor.
     * @param $itemRepository
     */
    public function __construct(CategoryContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return CategoryCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new CategoryCollection($items);
    }

    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new CategoryCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        return $this->responseCreatedJson();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);

        return $this->responseUpdatedJson();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $item = $this->itemRepository->deleteItem($id);

        return $this->responseUpdatedJson();
    }

}
