<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_repeat_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Activity[] $activities
 */
class ActivityRepeatType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => Yii::t('app', 'Название'),
        ]);
    }

}
