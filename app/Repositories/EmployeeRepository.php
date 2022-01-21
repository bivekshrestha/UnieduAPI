<?php

namespace App\Repositories;

use App\Contracts\EmployeeContract;
use App\Models\Company\Employee;
use App\Models\Image;
use App\Traits\ImageUploadAble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class EmployeeRepository extends BaseRepository implements EmployeeContract
{
    use ImageUploadAble;

    /**
     * EmployeeRepository constructor.
     * @param Employee $model
     */
    public function __construct(Employee $model)
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

            $merge = $collection->except('image');

            $item = new Employee($merge->all());
            $item->save();

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {

                $imagePath = $this->uploadImage($params['image'], 'images/avatars/', 200, 200);
                $image = new Image(['path' => $imagePath]);
                $item->avatar()->save($image);
            }

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

        $merge = $collection->except('image');

        $item->update($merge->all());

        if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {

            /**
             * Delete existing image
             */
            if ($item->avatar != null) {
                $this->deleteImage($item->avatar->path);
                $item->image()->delete();
            }

            $imagePath = $this->uploadImage($params['image'], 'images/avatars/', 200, 200);
            $image = new Image(['path' => $imagePath]);
            $item->avatar()->save($image);
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

        if ($item->avatar != null) {
            $this->deleteImage($item->avatar->path);
            $item->image()->delete();
        }

        $item->delete();

        return $item;
    }

}
