<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CandidateContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\CandidateCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CandidateController extends BaseController
{

    protected $itemRepository;

    /**
     * CandidateController constructor.
     * @param $itemRepository
     */
    public function __construct(CandidateContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return CandidateCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new CandidateCollection($items);
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
