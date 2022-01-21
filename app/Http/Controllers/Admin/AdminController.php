<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\AdminCollection;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends BaseController
{

    protected $itemRepository;

    /**
     * AdminController constructor.
     * @param $itemRepository
     */
    public function __construct(AdminContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return AdminCollection
     */
    public function index()
    {
        $items = Admin::withFormatUser();

        return new AdminCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:App\Models\User'
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        return $this->responseJson(true, 201, $item);

    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [

        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);

        return $this->responseJson(true, 206);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $item = $this->itemRepository->deleteItem($id);

        return $this->responseJson(true, 204);
    }

}
