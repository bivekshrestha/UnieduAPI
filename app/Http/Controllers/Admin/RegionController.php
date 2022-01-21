<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\RegionContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\RegionCollection;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegionController extends BaseController
{

    protected $itemRepository;

    /**
     * RegionController constructor.
     * @param $itemRepository
     */
    public function __construct(RegionContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return RegionCollection
     */
    public function index()
    {
        $items = Region::withFormatCountries();

        return new RegionCollection($items);
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

    public function linkCountries(Request $request)
    {
        $item = $this->itemRepository->findRegionById($request->id);

        $item->countries()->sync($request->countries);

        return $this->responseUpdatedJson();
    }

}
