<?php

namespace App\Http\Controllers\App;

use App\Contracts\PermissionContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\PermissionCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PermissionController extends BaseController
{

    protected $itemRepository;

    /**
     * PermissionController constructor.
     * @param $itemRepository
     */
    public function __construct(PermissionContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return PermissionCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new PermissionCollection($items);
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
