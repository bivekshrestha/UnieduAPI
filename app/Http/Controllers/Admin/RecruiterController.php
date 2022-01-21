<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\RecruiterContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\RecruiterCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecruiterController extends BaseController
{

    protected $itemRepository;

    /**
     * RecruiterController constructor.
     * @param $itemRepository
     */
    public function __construct(RecruiterContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return RecruiterCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new RecruiterCollection($items);
    }

    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new RecruiterCollection($items);
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
