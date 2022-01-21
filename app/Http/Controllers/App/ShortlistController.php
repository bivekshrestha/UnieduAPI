<?php

namespace App\Http\Controllers\App;

use App\Contracts\ShortlistContract;
use App\Http\Controllers\BaseController;
use App\Models\Students\Shortlist;
use App\Models\Students\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShortlistController extends BaseController
{

    protected $itemRepository;

    /**
     * StudentController constructor.
     * @param $itemRepository
     */
    public function __construct(ShortlistContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function show($id)
    {
        return Shortlist::where('student_id', $id)
            ->get()
            ->pluck('course_id')
            ->flatten();
    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function showDetails($id)
    {
        return Shortlist::with('course.institution')
            ->where('student_id', $id)
            ->get();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
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

    public function deleteChecked(Request $request)
    {
        $item = Shortlist::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->first();

        $item->delete();

        return $this->responseUpdatedJson();
    }

}
