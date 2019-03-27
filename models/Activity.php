<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 21:59
 */

namespace app\models;


use app\base\BaseModel;

class Activity extends BaseModel
{
    public $title;

    public $description;

    public $date_start;

    public $repeat_type;

    public $is_blocked;

    protected static $repeat_types = [
        0 => 'Без повтора',
        1 => 'Ежедневно',
        2 => 'Еженедельно',
        3 => 'Ежемесячно',
        4 => 'Ежегодно'
    ];

    public function rules()
    {
        return [
            ['title', 'required'],
            ['description', 'string', 'min' => 10],
            ['is_blocked', 'boolean'],
            ['repeat_type', 'in', 'range' => array_keys($this->getRepeatTypes())],
            ['date_start', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название активности',
            'description' => 'Описание',
            'date_start' => 'Дата начала',
            'repeat_type' => 'Повтор',
            'is_blocked' => 'Блокирующее событие',
        ];
    }

    public function getRepeatTypes() {
        return static::$repeat_types;
    }

    public function getRepeatType($id) {
        $data = $this->getRepeatTypes();
        return array_key_exists($id, $data) ? $data[$id] : false;
    }
}