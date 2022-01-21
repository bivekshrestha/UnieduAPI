<?php

namespace App\Repositories;

use App\Contracts\AdminContract;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AdminRepository extends BaseRepository implements AdminContract
{

    /**
     * AdminRepository constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
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
            $user->roles()->attach($collection['roles']);

            $data = $collection->except('first_name', 'last_name', 'email', 'is_active', 'roles');

            $user_id = $user->id;

            $data = $data->merge(compact('user_id'));

            $item = new Admin($data->all());
            $item->save();

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

        $collection = collect($params)->except('_token', 'user');

        $merge = $collection->only('first_name', 'last_name', 'email', 'is_active');

        $user = User::findOrFail($collection['user_id']);
        $user->update($merge->all());
        $user->roles()->sync($collection['roles']);

        $data = $collection->except('first_name', 'last_name', 'email', 'is_active', 'roles');

        $user_id = $user->id;

        $data = $data->merge(compact('user_id'));

        $item->update($data->all());

        return $item;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public
    function deleteItem($id)
    {
        $item = User::findOrFail($id);

        $item->delete();
//        $item = $this->findItemById($id);
//
//        $item->delete();

        return $item;
    }

}
