<?php

namespace App\Http\Controllers\App;

use App\Contracts\CountryContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\CountryCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CountryController extends BaseController
{

    protected $itemRepository;

    /**
     * CountryController constructor.
     * @param $itemRepository
     */
    public function __construct(CountryContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return CountryCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new CountryCollection($items);
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
