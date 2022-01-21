<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\InstitutionContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\InstitutionCollection;
use App\Http\Resources\InstitutionResource;
use App\Imports\InstitutionImport;
use App\Models\Partners\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class InstitutionController extends BaseController
{

    protected $itemRepository;

    /**
     * InstitutionController constructor.
     * @param $itemRepository
     */
    public function __construct(InstitutionContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return InstitutionCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['image']);

        return new InstitutionCollection($items);
    }

    /**
     * @return InstitutionCollection
     */
    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new InstitutionCollection($items);
    }

    public function show($id)
    {
        $item = $this->itemRepository->findItemById($id);

        return new InstitutionResource($item);
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function file(Request $request)
    {
        $file = $request->file('institutions');

        $collection = Excel::toCollection(new InstitutionImport(), $file);
        $temp = $collection[0]->filter(function ($item) {
            return $item->filter();
        });

        $institutions = $temp->filter(function ($item) {
            if ($item['name'] != null) {
                return $item;
            }
        });

//        return $institutions;

        foreach ($institutions as $institution) {
            $institution = $institution->filter()->toArray();
            $item = $this->itemRepository->createItem($institution);
        }

        return $this->responseCreatedJson();
    }

}
