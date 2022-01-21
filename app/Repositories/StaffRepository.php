<?php

namespace App\Repositories;

use App\Contracts\StaffContract;
use App\Models\Partners\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class StaffRepository extends BaseRepository implements StaffContract
{

    /**
     * StaffRepository constructor.
     * @param Staff $model
     */
    public function __construct(Staff $model)
    {
        parent::__construct($model);
        $this->model = $model;
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
     * @return mixed
     */
    public function listItemsForSelect()
    {
        return $this->selectAsTextValuePair('first_name', 'user_id');
    }

    /**
     * @return mixed
     */
    public function listItemsForSelectOnlyLabel()
    {
        return $this->pluck('first_name');
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
     * @param array $params
     * @return bool|mixed
     */
    public function createItem(array $params)
    {
        try {
            $collection = collect($params);

            $merge = $collection->only('first_name', 'last_name', 'email', 'is_active');
            $user = User::create($merge->all());

            $staff = $collection->only('job_title', 'phone_number', 'recruiter_id');
            $item = new Staff($staff->all());

            $user->staff()->save($item);

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

        $merge = $collection->only('job_title', 'phone_number');

        $item->update($merge->all());

        $item->user()->update(['is_active' => $params['is_active']]);

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
