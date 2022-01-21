<?php

namespace App\Http\Controllers\App;

use App\Contracts\IntakeContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\IntakeCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IntakeController extends BaseController
{

    protected $itemRepository;

    /**
     * IntakeController constructor.
     * @param $itemRepository
     */
    public function __construct(IntakeContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return IntakeCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new IntakeCollection($items);
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
