<?php

namespace App\Http\Controllers\App;

use App\Contracts\StudentEducationContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\StudentEducationCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentEducationController extends BaseController
{

    protected $itemRepository;

    /**
     * EducationController constructor.
     * @param $itemRepository
     */
    public function __construct(StudentEducationContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return StudentEducationCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItems();

        return new StudentEducationCollection($items);
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
