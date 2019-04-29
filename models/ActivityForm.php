<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class ActivityForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $date_start;
    public $date_end;
    public $repeat_type_id;
    public $is_blocked;
    public $use_notification;
    public $images = [];
    public $savedImages = [];

    public $commonFields = [
        'user_id',
        'title',
        'description',
        'repeat_type_id',
        'is_blocked',
        'use_notification'
    ];

    public function rules()
    {
        return [
            [['title', 'description'], 'trim'],
            [['title', 'date_start'], 'required'],
            ['description', 'string', 'max' => 255],
            [['is_blocked', 'use_notification'], 'boolean'],
            ['repeat_type_id', 'in', 'range' => array_keys(static::getRepeatTypes())],
            [['date_start', 'date_end'], 'date', 'format' => 'php:d.m.Y'],
            [['date_start', 'date_end'], 'validateDates'],
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 10],
            ['savedImages', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('app', 'Название'),
            'description' => \Yii::t('app', 'Описание'),
            'date_start' => \Yii::t('app', 'Дата начала'),
            'date_end' => \Yii::t('app', 'Дата окончания'),
            'repeat_type_id' => \Yii::t('app', 'Повтор'),
            'is_blocked' => \Yii::t('app', 'Блокирующее событие'),
            'use_notification' => \Yii::t('app', 'Уведомить о событии'),
            'images' => \Yii::t('app', 'Картинки')
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
                $this->addError('date_start', 'Дата начала уже прошла');
            }
        }
        if ($attribute == 'date_end') {
            if ($date_start && $date_end && $date_end < $date_start) {
                $this->addError('date_end', 'Дата окончания не может быть меньше даты начала');
            }
        }
    }

    public function getRepeatTypes() {
        static $repeat_types;
        if (!isset($repeat_types)) {
            $repeat_types = ActivityRepeatType::find()->asArray()->all();
            $repeat_types = ArrayHelper::map($repeat_types, 'id', 'name');
        }
        return $repeat_types;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateStartDateTime()
    {
        if ($this->date_start) {
            if ($date = \DateTime::createFromFormat('d.m.Y', $this->date_start)) {
                $date->setTime(0, 0, 0);
                return $date;
            }
        }

        return null;
    }

    public function setDateStartFromDateTime(\DateTime $date)
    {
        $this->date_start = $date->format('d.m.Y');
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEndDateTime()
    {
        if ($this->date_end) {
            if ($date = \DateTime::createFromFormat('d.m.Y', $this->date_end)) {
                $date->setTime(23, 59, 59);
                return $date;
            }
        }

        return null;
    }

    public function setDateEndFromDateTime(\DateTime $date)
    {
        $this->date_end = $date->format('d.m.Y');
    }

}
