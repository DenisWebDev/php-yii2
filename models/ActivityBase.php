<?php

namespace app\models;

use app\modules\auth\models\User;
use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $date_start
 * @property string $date_end
 * @property int $repeat_type_id
 * @property int $is_blocked
 * @property int $use_notification
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ActivityRepeatType $repeatType
 * @property User $user
 * @property ActivityImage[] $activityImages
 */
class ActivityBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'date_start', 'repeat_type_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'repeat_type_id', 'is_blocked', 'use_notification', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['repeat_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityRepeatType::className(), 'targetAttribute' => ['repeat_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'repeat_type_id' => Yii::t('app', 'Repeat Type ID'),
            'is_blocked' => Yii::t('app', 'Is Blocked'),
            'use_notification' => Yii::t('app', 'Use Notification'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepeatType()
    {
        return $this->hasOne(ActivityRepeatType::className(), ['id' => 'repeat_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityImages()
    {
        return $this->hasMany(ActivityImage::className(), ['activity_id' => 'id']);
    }
}
