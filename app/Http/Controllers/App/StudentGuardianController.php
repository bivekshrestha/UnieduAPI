<?php

namespace App\Http\Controllers\App;

use App\Contracts\StudentGuardianContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\StudentGuardianCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentGuardianController extends BaseController
{

    protected $itemRepository;

    /**
     * GuardianController constructor.
     * @param $itemRepository
     */
    public function __construct(StudentGuardianContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return StudentGuardianCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new StudentGuardianCollection($items);
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
