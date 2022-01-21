<?php

namespace App\Http\Controllers\App;

use App\Contracts\TeamContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\TeamCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends BaseController
{

    protected $itemRepository;

    /**
     * TeamController constructor.
     * @param $itemRepository
     */
    public function __construct(TeamContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return TeamCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['staffs']);

        foreach ($items as $item) {
            $full = [];
            $partial = [];
            foreach ($item->staffs as $staff) {
                $user = User::with('permissions')->where('id', $staff->user_id)->first();

                foreach ($user->permissions as $value) {
                    if ($value->slug == 'full') {
                        array_push($full, $user->id);
                    } else {
                        array_push($partial, $user->id);
                    }
                }

            }
            $item->full = $full;
            $item->partial = $partial;
            unset($item->staffs);
        }

        return new TeamCollection($items);
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
            'name' => 'required'
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
        $item = $this->itemRepository->findTeamById($request->id);

        $item->sync($request->countries);

        return $this->responseUpdatedJson();
    }

}
