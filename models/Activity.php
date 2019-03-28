<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 21:59
 */

namespace app\models;


use app\base\BaseModel;
use app\models\rules\PhoneRuRule;

class Activity extends BaseModel
{
    public $title;

    public $description;

    public $date_start;

    public $date_end;

    public $images;

    public $repeat_type;

    public $is_blocked;

    public $notify_phone;

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
            [['title', 'description', 'notify_phone'], 'trim'],
            [['title', 'date_start'], 'required'],
            ['description', 'string', 'max' => 255],
            ['is_blocked', 'boolean'],
            ['repeat_type', 'in', 'range' => array_keys(static::$repeat_types)],
            [['date_start', 'date_end'], 'date', 'format' => 'php:d.m.Y'],
            ['notify_phone', PhoneRuRule::class],
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 10]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'repeat_type' => 'Повтор',
            'is_blocked' => 'Блокирующее событие',
            'notify_phone' => 'Уведомить по телефону',
            'images' => 'Картинки'
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