<?php

namespace App\Http\Controllers\App;

use App\Contracts\RecruiterContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\RecruiterCollection;
use App\Models\Partners\Staff;
use App\Models\Partners\Team;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecruiterController extends BaseController
{

    protected $itemRepository;

    /**
     * RecruiterController constructor.
     * @param $itemRepository
     */
    public function __construct(RecruiterContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return RecruiterCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new RecruiterCollection($items);
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
    public function register(Request $request)
    {
        $this->validate($request, [
            'country' => 'required',
            'city' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
        ]);

        $params = $request->only('country', 'city');

        $item = $this->itemRepository->createItem($params);

        $team = Team::create([
            'recruiter_id' => $item->id,
            'name' => 'Admin',
            'description' => 'This is your default administrator team.',
            'status' => true
        ]);

        $user = User::create($request->only('email', 'first_name', 'last_name'));
        $role = Role::where('slug', 'recruiter')->first();
        $permission = Permission::where('slug', 'full')->first();

        $user->roles()->attach($role);
        $user->roles()->attach($permission);

        $staff = Staff::create([
            'recruiter_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $team->staffs()->attach($staff);


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
        $item = $this->itemRepository->findRecruiterById($request->id);

        $item->sync($request->countries);

        return $this->responseUpdatedJson();
    }

}
