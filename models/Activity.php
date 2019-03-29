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
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Activity extends BaseModel
{
    public $title;

    public $description;

    public $date_start;

    public $date_end;

    public $images;

    public $repeat_type_id;

    public $is_blocked;

    public $use_notification;

    public $email;

    public function rules()
    {
        return [
            [['title', 'description', 'email'], 'trim'],
            [['title', 'date_start'], 'required'],
            ['description', 'string', 'max' => 255],
            [['is_blocked', 'use_notification'], 'boolean'],
            ['repeat_type_id', 'in', 'range' => array_keys(static::getRepeatTypes())],
            [['date_start', 'date_end'], 'date', 'format' => 'php:d.m.Y'],
            [['date_start', 'date_end'], 'validateDates'],
            ['email', 'required', 'when' => function($model) {
                return $model->use_notification == 1 ? true : false;
            }],
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
            'repeat_type_id' => 'Повтор',
            'is_blocked' => 'Блокирующее событие',
            'use_notification' => 'Уведомить о событии',
            'images' => 'Картинки'
        ];
    }

    /**
     * @param $attribute
     * @throws \Exception
     */
    public function validateDates($attribute) {
        $date_start = \DateTime::createFromFormat('d.m.Y', $this->date_start);
        $date_start = $date_start ? intval($date_start->format('Ymd')) : 0;

        $date_end = \DateTime::createFromFormat('d.m.Y', $this->date_end);
        $date_end = $date_end ? intval($date_end->format('Ymd')) : 0;

        $current_date = intval((new \DateTime())->format('Ymd'));

        if ($attribute == 'date_start') {
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
        static $repeat_types;
        if (!isset($repeat_types)) {
            $repeat_types = (new Query())->select('*')
                ->from('activity_repeat_type')->all();
            $repeat_types = ArrayHelper::map($repeat_types, 'id', 'name');
        }
        return $repeat_types;
    }

    public function getRepeatType($id) {
        $data = $this->getRepeatTypes();
        return array_key_exists($id, $data) ? $data[$id] : false;
    }
}