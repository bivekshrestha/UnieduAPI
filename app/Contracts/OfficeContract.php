<?php

namespace App\Contracts;

/**
 * Interface ArticleContract
 * @package App\Contracts
 */
interface OfficeContract
{
    /***
     * @param array $columns
     * @param string $order
     * @param string $sort
     * @return mixed
     */
    public function listItems(array $columns = ['*'], string $order = 'id', string $sort = 'asc');

    /**
     * @param array $relations
     * @param array $columns
     * @param string $order
     * @param string $sort
     * @return mixed
     */
    public function listItemsWith(array $relations = [], array $columns = ['*'], string $order = 'id', string $sort = 'asc');

    /**
     * @param int $id
     * @return mixed
     */
    public function findItemById(int $id);

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
     * @param $id
     * @return bool
     */
    public function deleteItem($id);
}
