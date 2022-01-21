<?php

namespace App\Repositories;

use App\Contracts\StudentContract;
use App\Contracts\StudentEducationContract;
use App\Contracts\StudentGuardianContract;
use App\Models\Students\Student;
use App\Models\Students\StudentDetail;
use App\Models\Students\StudentDocument;
use App\Models\Students\StudentPreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

class StudentRepository extends BaseRepository implements StudentContract
{

    protected $studentGuardianRepository;
    protected $studentEducationRepository;

    /**
     * StudentRepository constructor.
     * @param Student $model
     * @param StudentGuardianContract $studentGuardianRepository
     * @param StudentEducationContract $studentEducationRepository
     */
    public function __construct(
        Student $model,
        StudentGuardianContract $studentGuardianRepository,
        StudentEducationContract $studentEducationRepository
    )
    {
        parent::__construct($model);
        $this->model = $model;
        $this->studentGuardianRepository = $studentGuardianRepository;
        $this->studentEducationRepository = $studentEducationRepository;
    }

    /**
     * @param array $columns
     * @param string $order
     * @param string $sort
     * @return mixed
     */
    public function listItems(array $columns = ['*'], string $order = 'id', string $sort = 'asc')
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param array $relations
     * @param array $columns
     * @param string $order
     * @param string $sort
     * @return Builder[]|Collection|mixed
     */
    public function listItemsWith(array $relations = [], array $columns = ['*'], string $order = 'id', string $sort = 'asc')
    {
        return $this->getWith($relations, $columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findItemById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw  new ModelNotFoundException($e);
        }
    }

    /**
     * @param int $id
     * @param $relations
     * @return Builder|Model
     */
    public function findItemByIdWith(int $id, array $relations)
    {
        try {
            return $this->findOneByIdWith($id, $relations);
        } catch (ModelNotFoundException $e) {

            throw  new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return bool|mixed
     */
    public function createItem(array $params)
    {
        try {
            $collection = collect($params);

            $merge = $collection->only('recruiter_id', 'lead_id', 'staff_id', 'reference', 'lead_status');
            $item = new Student($merge->all());
            $item->save();

            $details_data = $collection->except('recruiter_id', 'lead_id', 'staff_id', 'reference', 'lead_status');

            $detail = new StudentDetail($details_data->all());
            $item->detail()->save($detail);

            $preference = new StudentPreference();
            $item->preference()->save($preference);

            $item->documents()->save(new StudentDocument([
                'name' => 'academic',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'passport',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'language',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'resume',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'personal_statement',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'photo',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'visa',
                'type' => 'mandatory',
            ]));

            $item->documents()->save(new StudentDocument([
                'name' => 'offer_letter',
                'type' => 'mandatory',
            ]));

            return $item;

        } catch (QueryException $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params)
    {
        $item = $this->findItemById($params['id']);

        $collection = collect($params)->except('_token');

        $merge = $collection->except('detail', 'preference', 'shortlists', 'guardians', 'educations');
        $item->update($merge->all());

        $detail = $collection->only('detail');
        $item->detail()->update($detail->first());

        $preference = $collection->only('preference');
        $item->preference()->update($preference->first());

        $guardians = $params['guardians'];
        foreach ($guardians as $guardian) {
            $linkData = $this->studentGuardianRepository->updateOrCreateItem($guardian);
            if (!Arr::has($guardian, 'id')) {
                $item->guardians()->save($linkData);
            }
        }

        $educations = $params['educations'];
        foreach ($educations as $education) {
            $linkData = $this->studentEducationRepository->updateOrCreateItem($education);
            if (!Arr::has($education, 'id')) {
                $item->educations()->save($linkData);
            }
        }

        return $item;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public
    function deleteItem($id)
    {
        $item = $this->findItemById($id);

        $item->delete();

        return $item;
    }

}
