<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\PackageContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\PackageCollection;
use App\Models\Company\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PackageController extends BaseController
{

    protected $itemRepository;

    /**
     * PackageController constructor.
     * @param $itemRepository
     */
    public function __construct(PackageContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return PackageCollection
     */
    public function index()
    {
        $packages = $this->itemRepository->listItems();

        return new PackageCollection($packages);
    }

    /**
     * @return PackageCollection
     */
    public function get()
    {
        $packages = $this->itemRepository->listItems();
        foreach ($packages as $package){
            $package->package_name = $package->name;
        }

        return new PackageCollection($packages);
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

        $item= $this->itemRepository->createItem($params);

        return $this->responseCreatedJson();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $params = $request->except('_token');

        $item= $this->itemRepository->updateItem($params);

        return $this->responseUpdatedJson();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $item= $this->itemRepository->deleteItem($id);

        return $this->responseUpdatedJson();
    }

}
