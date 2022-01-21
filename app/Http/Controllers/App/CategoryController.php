<?php

namespace App\Http\Controllers\App;

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
        $items = $this->itemRepository->listItemsWith(['articles']);

        return new CategoryCollection($items);
    }

    /**
     * @return JsonResponse
     */
    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return $this->responseJson(true, 200, $items);
    }

    /**
     * @return JsonResponse
     */
    public function getLabel()
    {
        $items = $this->itemRepository->listItemsForSelectOnlyLabel();

        return $this->responseJson(true, 200, $items);
    }

}
