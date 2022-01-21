<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\VacancyContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\VacancyCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VacancyController extends BaseController
{

    protected $itemRepository;

    /**
     * VacancyController constructor.
     * @param $itemRepository
     */
    public function __construct(VacancyContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return VacancyCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new VacancyCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'position' => 'required',
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
