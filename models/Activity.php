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

    public $is_blocked;

    public function rules()
    {
        return [
            ['title', 'required'],
            ['description', 'string', 'min' => 10],
            ['is_blocked', 'boolean'],
            ['date_start', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название активности',
            'description' => 'Описание',
            'date_start' => 'Дата начала',
            'is_blocked' => 'Блокирующее событие',
        ];
    }
}