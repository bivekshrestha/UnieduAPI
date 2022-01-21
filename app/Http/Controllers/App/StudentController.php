<?php

namespace App\Http\Controllers\App;

use App\Contracts\StudentContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\StudentCollection;
use App\Models\Partners\Staff;
use App\Models\Students\Student;
use App\Models\User;
use App\Notifications\StudentCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends BaseController
{

    protected $itemRepository;

    /**
     * StudentController constructor.
     * @param $itemRepository
     */
    public function __construct(StudentContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param $id
     * @return StudentCollection
     */
    public function getByRecruiterId($id)
    {
        $items = Student::where('recruiter_id', $id)
            ->with('detail:id,student_id,first_name,last_name')
            ->whereHas('detail')
            ->with('staff.user')
            ->get();

        return new StudentCollection($items);
    }

    /**
     * @param $id
     * @return StudentCollection
     */
    public function getByRecruiterIdAndPhase($id, $phase)
    {
        $items = Student::where('recruiter_id', $id)
            ->where('phase', $phase)
            ->with('detail:id,student_id,first_name,last_name')
            ->whereHas('detail')
            ->with('staff.user')
            ->get();

        return new StudentCollection($items);
    }

    /**
     * @param $id
     * @return StudentCollection
     */
    public function getByRecruiterIdUnassigned($id)
    {
        $items = Student::where('recruiter_id', $id)
            ->where('staff_id', null)
            ->with('detail:id,student_id,first_name,last_name')
            ->whereHas('detail')
            ->with('staff.user')
            ->get();

        return new StudentCollection($items);
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getApplicationPhaseCount($id)
    {
        return DB::table('students')
            ->where('recruiter_id', $id)
            ->select('phase', DB::raw('count(*) as total'))
            ->groupBy('phase')
            ->pluck('total')
            ->flatten();
    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function show($id)
    {
        return $this->itemRepository->findItemByIdWith($id, ['detail', 'preference', 'shortlists']);

    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function allDetails($id)
    {
        return $this->itemRepository->findItemByIdWith($id, ['detail', 'preference', 'shortlists', 'guardians', 'educations']);

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
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        $recruiter = Staff::where('recruiter_id', $item->recruiter_id)
            ->with('user')
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('slug', 'recruiter');
                });
            })->first();

        $user = User::findOrFail($recruiter->user_id);

        $user->notify(new StudentCreated());

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
        $item = $this->itemRepository->findStudentById($request->id);

        $item->sync($request->countries);

        return $this->responseUpdatedJson();
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function changePhase(Request $request, $id): bool
    {
        $student = Student::findOrFail($id);

        $student->phase = $request->phase;
        $student->save();

        return true;

    }

}
