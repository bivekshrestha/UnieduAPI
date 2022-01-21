<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\EmployeeContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\EmployeeCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeController extends BaseController
{

    protected $itemRepository;

    /**
     * EmployeeController constructor.
     * @param $itemRepository
     */
    public function __construct(EmployeeContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return EmployeeCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['avatar']);

        return new EmployeeCollection($items);
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

        $item = $this->itemRepository->createitem($params);

        return $this->responseCreatedJson();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $params = $request->except('_token');

        $item = $this->itemRepository->updateitem($params);

        return $this->responseUpdatedJson();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $item = $this->itemRepository->deleteitem($id);

        return $this->responseUpdatedJson();
    }

}
