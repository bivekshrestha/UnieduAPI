<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SettingContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\SettingCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SettingController extends BaseController
{

    protected $itemRepository;

    /**
     * SettingController constructor.
     * @param $itemRepository
     */
    public function __construct(SettingContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return SettingCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new SettingCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|unique:settings',
            'value' => 'required',
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
