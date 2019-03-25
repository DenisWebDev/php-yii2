<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 21:59
 */

namespace app\models;


use app\base\BaseModel;
use app\models\rules\NotAdminRule;

class Activity extends BaseModel
{
    public $title;

    public $description;

    public $date_start;

    public $repeat_type;

    public $is_blocked;

    public $email;

    public $repeat_email;

    public $use_notification;

    public $file;

    protected static $repeat_types = [
        0 => 'Без повтора',
        1 => 'Ежедневно',
        2 => 'Еженедельно',
        3 => 'Ежемесячно',
        4 => 'Ежегодно',
//        5=>'не допустимо'
    ];

    public function beforeValidate()
    {
        if($this->date_start){
            $date=\DateTime::createFromFormat('d.m.Y',$this->date_start);
            if($date){
                $this->date_start=$date->format('Y-m-d');
            }
        }

        return parent::beforeValidate();
    }

    public function rules()
    {
        return [
            [['title','date_start'], 'required'],
            [['title','description'],'trim'],
            ['description', 'string', 'min' => 10, 'max' => 300],
            [['is_blocked','use_notification'], 'boolean'],
            ['date_start','date','format' => 'php:Y-m-d'],
            ['email','email'],
//            ['title','match','pattern' => '/w+{10,}/'],
            ['repeat_email','compare','compareAttribute' => 'email' ,'message' => 'Значения email должны быть равны'],
            ['email','required','when' => function($model){
                return $model->use_notification==1?true:false;
            }],
            ['file','file','extensions' => ['jpg','png']],
//            ['title','notAdmin'],
            [['title','description'],NotAdminRule::class],
            ['repeat_type','in','range' => array_keys(self::$repeat_types)]
        ];
    }

    public function notAdmin($attr){
        if($this->title=='admin'){
            $this->addError('title','Значения заголовка не должно быть admin');
        }
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название активности',
            'use_notification'=>'Уведомлять о событии',
            'description' => 'Описание',
            'date_start' => 'Дата начала',
            'repeat_type' => 'Повтор',
            'is_blocked' => 'Блокирующее событие',
        ];
    }

    public function getRepeatTypes() {
        return array_merge(static::$repeat_types,[5=>'Не допустимо']);
    }

    public function getRepeatType($id) {
        $data = $this->getRepeatTypes();
        return array_key_exists($id, $data) ? $data[$id] : false;
    }
}