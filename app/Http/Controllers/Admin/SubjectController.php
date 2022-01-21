<?php

namespace App\Http\Controllers\Admin;

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

    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new SubjectCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
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
