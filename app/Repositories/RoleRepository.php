<?php

namespace App\Repositories;

use App\Contracts\RoleContract;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class RoleRepository extends BaseRepository implements RoleContract
{

    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
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
        return $this->selectAsTextValuePair('title', 'id');
    }

    /**
     * @return mixed
     */
    public function listItemsForSelectOnlyLabel()
    {
        return $this->pluck('label');
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

            $item = new Role($collection->all());
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

        $collection = collect($params)->except('_token');

        $item->update($collection->all());


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
