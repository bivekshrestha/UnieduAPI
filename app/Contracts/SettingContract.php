<?php

namespace App\Contracts;

/**
 * Interface SettingContract
 * @package App\Contracts
 */
interface SettingContract
{
    /***
     * @param array $columns
     * @param string $order
     * @param string $sort
     * @return mixed
     */
    public function listItems(array $columns = ['*'], string $order = 'id', string $sort = 'asc');

    /**
     * @param $setting
     * @return mixed
     */
    public function setConfig($setting);

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
