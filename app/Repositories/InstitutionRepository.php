<?php

namespace App\Repositories;

use App\Contracts\InstitutionContract;
use App\Models\Partners\Institution;
use App\Models\Image;
use App\Traits\ImageUploadAble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class InstitutionRepository extends BaseRepository implements InstitutionContract
{
    use ImageUploadAble;

    /**
     * InstitutionRepository constructor.
     * @param Institution $model
     */
    public function __construct(Institution $model)
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

            $merge = $collection->except('image');

            $item = new Institution($merge->all());
            $item->save();

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {

                $imagePath = $this->uploadImage($params['image'], 'images/institutions/', 200, 200);
                $image = new Image(['path' => $imagePath]);
                $item->image()->save($image);
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
            if ($item->image != null) {
                $this->deleteImage($item->image->path);
                $item->image()->delete();
            }

            $imagePath = $this->uploadImage($params['image'], 'images/institutions/', 200, 200);
            $image = new Image(['path' => $imagePath]);
            $item->image()->save($image);
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

        if ($item->image != null) {
            $this->deleteImage($item->image->path);
            $item->image()->delete();
        }

        $item->delete();

        return $item;
    }

}
