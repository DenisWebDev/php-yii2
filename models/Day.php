<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.03.2019
 * Time: 21:53
 */

namespace app\models;


use app\base\BaseModel;

class Day extends BaseModel
{
    public $type;

    public $activities;

    protected static $types = [
        0 => 'Рабочий',
        1 => 'Выходной',
    ];

    public function rules()
    {
        return [
            ['type', 'in', 'range' => array_keys($this->getTypes())],
        ];
    }

    public function getTypes() {
        return static::$types;
    }

    public function getType($id) {
        $data = $this->getTypes();
        return array_key_exists($id, $data) ? $data[$id] : false;
    }

}