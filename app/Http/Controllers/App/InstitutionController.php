<?php

namespace App\Http\Controllers\App;

use App\Contracts\InstitutionContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\InstitutionCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstitutionController extends BaseController
{

    protected $itemRepository;

    /**
     * InstitutionController constructor.
     * @param $itemRepository
     */
    public function __construct(InstitutionContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return InstitutionCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new InstitutionCollection($items);
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
