<?php

namespace App\Contracts;

/**
 * Interface StudentEducationContract
 * @package App\Contracts
 */
interface StudentEducationContract
{
    /***
     * @param array $columns
     * @param $order
     * @param $sort
     * @return mixed
     */
    public function listItems(array $columns = ['*'], $order = 'id', $sort = 'asc');

    /**
     * @param array $relations
     * @param array $columns
     * @param $order
     * @param $sort
     * @return mixed
     */
    public function listItemsWith(array $relations = [], array $columns = ['*'], $order = 'id', $sort = 'asc');

    /**
     * @param $id
     * @return mixed
     */
    public function findItemById($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createItem(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateOrCreateItem(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteItem($id);
}
