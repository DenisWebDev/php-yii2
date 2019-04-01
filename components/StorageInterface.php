<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.03.2019
 * Time: 1:16
 */

namespace app\components;


interface StorageInterface
{
    public function add($table, $data);

    public function get($table, $id);

    public function getList($table, $options = []);

}