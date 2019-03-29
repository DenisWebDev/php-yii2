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
            [['date_start', 'date_end'], 'validateDates'],
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

    public function validateDates($attribute) {
        $date_start = \DateTime::createFromFormat('d.m.Y', $this->date_start)->setTime(0, 0, 0);
        $date_end = \DateTime::createFromFormat('d.m.Y', $this->date_end)->setTime(0, 0, 0);
        if ($attribute == 'date_start') {
            $current_date = (new \DateTime())->setTime(0, 0, 0);
            if ($date_start && $date_start <= $current_date) {
                $this->addError('date_start','Дата начала уже прошла');
            }
        }
        if ($attribute == 'date_end') {
            if ($date_start && $date_end && $date_end < $date_start) {
                $this->addError('date_end','Дата окончания не может быть меньше даты начала');
            }
        }
    }

    public function getRepeatTypes() {
        return static::$repeat_types;
    }

    public function getRepeatType($id) {
        $data = $this->getRepeatTypes();
        return array_key_exists($id, $data) ? $data[$id] : false;
    }
}