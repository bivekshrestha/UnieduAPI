<?php

namespace App\Http\Controllers\App;

use App\Contracts\StudentDocumentContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\StudentCollection;
use App\Models\Students\Student;
use App\Models\Students\StudentDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentDocumentController extends BaseController
{

    protected $itemRepository;

    /**
     * StudentDocumentController constructor.
     * @param $itemRepository
     */
    public function __construct(StudentDocumentContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param $student_id
     * @return mixed
     */
    public function get($student_id)
    {
        return StudentDocument::where('student_id', $student_id)
            ->where('type', 'mandatory')
            ->get();
    }

    /**
     * @param $student_id
     * @return mixed
     */
    public function getAdditional($student_id)
    {
        return StudentDocument::where('student_id', $student_id)
            ->where('type', 'additional')
            ->get();
    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function show($id)
    {


    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'first_name' => 'required',
//        ]);

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

}
