<?php

namespace App\Http\Controllers\App;

use App\Contracts\LeadContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\LeadCollection;
use App\Models\Partners\Lead;
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

    /**
     * @return JsonResponse
     */
    public function select()
    {
        $items = Lead::selectData();

        return $this->responseJson(true, 200, $items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'city' => 'required',
            'phone_number' => 'required',
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
