<?php


namespace App\Repositories;


use App\Contracts\StudentDocumentContract;
use App\Models\Students\StudentDocument;
use App\Traits\FileUploadAble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class StudentDocumentRepository extends BaseRepository implements StudentDocumentContract
{
    use FileUploadAble;

    /**
     * StudentDocumentRepository constructor.
     * @param StudentDocument $model
     */
    public function __construct(StudentDocument $model)
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

            $merge = $collection->except('path');

            $item = new StudentDocument($merge->all());

            if ($collection->has('path') && ($params['path'] instanceof UploadedFile)) {

                $documentPath = $this->uploadFile($params['path'], 'documents');
                $item->path = $documentPath;
                $item->status = true;
                $item->save();
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

        $merge = $collection->except('path');

        $item->update($merge->all());

        if ($collection->has('path') && ($params['path'] instanceof UploadedFile)) {

            /**
             * Delete existing document
             */
            if ($item->path) {
                $this->deleteFile($item->path);
            }

            $documentPath = $this->uploadFile($params['path'], 'documents');
            $item->path = $documentPath;
            $item->status = true;
            $item->save();
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

        if ($item->path) {
            $this->deleteFile($item->path);
        }

        $item->delete();

        return $item;
    }

}
