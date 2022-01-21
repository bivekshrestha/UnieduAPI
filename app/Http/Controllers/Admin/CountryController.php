<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CountryContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\CountryCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CountryController extends BaseController
{

    protected $itemRepository;

    /**
     * CountryController constructor.
     * @param $itemRepository
     */
    public function __construct(CountryContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return CountryCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new CountryCollection($items);
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

    public function addCountries(Request $request)
    {
        $item = $this->itemRepository->findCountryById($request->id);

        $item->sync($request->countries);

        return $this->responseUpdatedJson();
    }

}
