<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_image".
 *
 * @property int $id
 * @property int $activity_id
 * @property string $name
 *
 * @property Activity $activity
 */
class ActivityImageBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'name'], 'required'],
            [['activity_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }
}
