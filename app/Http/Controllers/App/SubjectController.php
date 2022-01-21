<?php

namespace App\Http\Controllers\App;

use App\Contracts\SubjectContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\SubjectCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends BaseController
{

    protected $itemRepository;

    /**
     * SubjectController constructor.
     * @param $itemRepository
     */
    public function __construct(SubjectContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return SubjectCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new SubjectCollection($items);
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
