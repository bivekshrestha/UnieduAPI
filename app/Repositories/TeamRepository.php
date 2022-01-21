<?php

namespace App\Repositories;

use App\Contracts\TeamContract;
use App\Models\Partners\Team;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TeamRepository extends BaseRepository implements TeamContract
{

    /**
     * TeamRepository constructor.
     * @param Team $model
     */
    public function __construct(Team $model)
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
        return $this->selectAsTextValuePair('name', 'id');
    }

    /**
     * @return mixed
     */
    public function listItemsForSelectOnlyLabel()
    {
        return $this->pluck('name');
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

            $merge = $collection->except('full', 'partial');

            $item = new Team($merge->all());
            $item->save();

            $staffs = [];
            if ($params['full']) {
                $permission = Permission::where('slug', 'full')->first();
                foreach ($params['full'] as $id) {
                    $user = User::with('staff')->where('id', $id)->first();
                    $user->permissions()->sync($permission);
                    array_push($staffs, $user->staff->id);
                }
            }

            if ($params['partial']) {
                $permission = Permission::where('slug', 'partial')->first();
                foreach ($params['partial'] as $id) {
                    $user = User::with('staff')->where('id', $id)->first();
                    $user->permissions()->sync($permission);
                    array_push($staffs, $user->staff->id);
                }
            }

            $item->staffs()->attach($staffs);

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

        $merge = $collection->only('name', 'description', 'status', 'type');

        $item->update($merge->all());

        $staffs = [];
        if ($params['full']) {
            $permission = Permission::where('slug', 'full')->first();
            foreach ($params['full'] as $id) {
                $user = User::with('staff')->where('id', $id)->first();
                $user->permissions()->sync($permission);
                array_push($staffs, $user->staff->id);
            }
        }

        if ($params['partial']) {
            $permission = Permission::where('slug', 'partial')->first();
            foreach ($params['partial'] as $id) {
                $user = User::with('staff')->where('id', $id)->first();
                $user->permissions()->sync($permission);
                array_push($staffs, $user->staff->id);
            }
        }

        $item->staffs()->sync($staffs);

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
