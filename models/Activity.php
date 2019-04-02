<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 21:59
 */

namespace app\models;


use app\base\BaseModel;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Activity extends ActivityBase
{

    public $images;


    public function rules()
    {
        return array_merge([
            [['title', 'description', 'email'], 'trim'],
            [['title', 'date_start'], 'required'],
            ['description', 'string', 'max' => 255],
            [['is_blocked', 'use_notification'], 'boolean'],
            ['repeat_type_id', 'in', 'range' => array_keys(
                ArrayHelper::map($this->getRepeatType()->asArray()->all(),
                    'id','name'))],
            [['date_start', 'date_end'], 'date', 'format' => 'php:d.m.Y'],
            [['date_start', 'date_end'], 'validateDates'],
            ['email', 'required', 'when' => function($model) {
                return $model->use_notification == 1 ? true : false;
            }],
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 10]
        ],parent::rules());
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

    public function getDataForStorage() {
        $data = $this->attributes;

        $data['user_id'] = 1;

        // TODO картинки пока не храним
        unset($data['images']);

        $data['date_start'] = \DateTime::createFromFormat('d.m.Y', $data['date_start'])
            ->format('Y-m-d');

        if ($data['date_end']) {
            $data['date_end'] = \DateTime::createFromFormat('d.m.Y', $data['date_end'])
                ->format('Y-m-d');
        }

        return $data;
    }

    public function loadFromStorageData($data) {
        $data['images'] = array();

        $data['date_start'] = \DateTime::createFromFormat('Y-m-d H:i:s', $data['date_start'])
            ->format('d.m.Y');

        if ($data['date_end']) {
            $data['date_end'] = \DateTime::createFromFormat('Y-m-d H:i:s', $data['date_end'])
                ->format('d.m.Y');
        }

        $this->attributes = $data;
    }

//    public function getRepeatTypes() {
//        static $repeat_types;
//        if (!isset($repeat_types)) {
//            $repeat_types = (new Query())->select('*')
//                ->from('activity_repeat_type')->all();
//            $repeat_types = ArrayHelper::map($repeat_types, 'id', 'name');
//        }
//        return $repeat_types;
//    }
//
//    public function getRepeatTypeName($id) {
//        $data = $this->getRepeatTypes();
//        return array_key_exists($id, $data) ? $data[$id] : false;
//    }
}