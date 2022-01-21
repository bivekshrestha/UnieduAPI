<?php


namespace App\Repositories;


use App\Contracts\StudentEducationContract;
use App\Models\Students\StudentEducation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

class StudentEducationRepository extends BaseRepository implements StudentEducationContract
{

    /**
     * StudentEducationRepository constructor.
     * @param StudentEducation $model
     */
    public function __construct(StudentEducation $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function listItems(array $columns = ['*'], $order = 'id', $sort = 'asc')
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @inheritDoc
     */
    public function listItemsWith(array $relations = [], array $columns = ['*'], $order = 'id', $sort = 'asc')
    {
        return $this->getWith($relations, $columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findItemById($id)
    {
        try {

            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw  new ModelNotFoundException($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function createItem(array $params)
    {
        try {
            $collection = collect($params);
            $item = new StudentEducation($params);
//            $item->save();

            return $item;

        } catch (QueryException $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public
    function updateItem(array $params)
    {
        $item = $this->findItemById($params['id']);

        $collection = collect($params)->except('_token');

        $item->update($collection->all());

        return $item;
    }

    /**
     * @inheritDoc
     */
    public
    function updateOrCreateItem(array $params)
    {
        if (Arr::has($params, 'id')) {
            $this->updateItem($params);
        } else {
            return $this->createItem($params);
        }
    }

    /**
     * @inheritDoc
     */
    public
    function deleteItem($id)
    {
        $item = $this->findItemById($id);

        $item->delete();

        return $item;
    }
}
