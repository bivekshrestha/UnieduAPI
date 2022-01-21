<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\LeadContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\LeadCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LeadController extends BaseController
{

    protected $itemRepository;

    /**
     * LeadController constructor.
     * @param $itemRepository
     */
    public function __construct(LeadContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return LeadCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new LeadCollection($items);
    }

    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new LeadCollection($items);
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
