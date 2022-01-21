<?php

namespace App\Http\Controllers\App;

use App\Contracts\ProgramContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\ProgramCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProgramController extends BaseController
{

    protected $itemRepository;

    /**
     * ProgramController constructor.
     * @param $itemRepository
     */
    public function __construct(ProgramContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return ProgramCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new ProgramCollection($items);
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
