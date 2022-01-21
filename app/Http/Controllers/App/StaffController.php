<?php

namespace App\Http\Controllers\App;

use App\Contracts\StaffContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\StaffCollection;
use App\Models\Partners\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StaffController extends BaseController
{

    protected $itemRepository;

    /**
     * StaffController constructor.
     * @param $itemRepository
     */
    public function __construct(StaffContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return StaffCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['user']);

        return new StaffCollection($items);
    }

    /**
     * @param $id
     * @return StaffCollection
     */
    public function getByRecruiter($id)
    {
        $items = Staff::where('recruiter_id', $id)
            ->with('user')
            ->get();

        return new StaffCollection($items);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSelectByRecruiter($id)
    {
        $items = Staff::selectDataByRecruiter($id);

        return $this->responseJson(true, 200, $items);
    }

    /**
     * @return JsonResponse
     */
    public function getSelect()
    {
        $items = Staff::selectData();

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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
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
        $item = $this->itemRepository->findStaffById($request->id);

        $item->sync($request->countries);

        return $this->responseUpdatedJson();
    }

}
