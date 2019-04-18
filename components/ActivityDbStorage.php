<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2019
 * Time: 0:28
 */

namespace app\components;


use app\base\IActivityStorage;
use app\models\Activity;
use app\models\ActivityForm;
use app\models\ActivityImage;
use yii\base\Component;

class ActivityDbStorage extends Component implements IActivityStorage
{
    /**
     * @param $model
     * @return bool|int
     * @throws \yii\db\Exception
     * @throws \Throwable
     */
    public function save(ActivityForm $model)
    {
        if ($model->id) {
            $activity = Activity::findOne($model->id);
            if ($activity === null) {
                return false;
            }
        } else {
            $activity = new Activity();
        }

        $activity->user_id = $model->user_id;
        $activity->title = $model->title;
        $activity->description = $model->description;
        $activity->date_start = \DateTime::createFromFormat('d.m.Y', $model->date_start)
            ->format('Y-m-d H:i:s');
        if ($model->date_end) {
            $activity->date_end = \DateTime::createFromFormat('d.m.Y', $model->date_end)
                ->format('Y-m-d H:i:s');
        }
        $activity->repeat_type_id = $model->repeat_type_id;
        $activity->is_blocked = $model->is_blocked;
        $activity->use_notification = $model->use_notification;

        $transaction = \Yii::$app->db->beginTransaction();

        if ($activity->save()) {
            $oldImages = [];
            foreach ($activity->activityImages as $image) {
                $oldImages[$image->id] = $image['name'];
            }
            foreach ($model->images as $image) {
                if (in_array($image, $oldImages)) {
                    unset($oldImages[array_search($image, $oldImages)]);
                    continue;
                }
                $activityImage = new ActivityImage();
                $activityImage->activity_id = $activity->id;
                $activityImage->name = $image;
                if (!$activityImage->save()) {
                    $transaction->rollBack();
                    return false;
                }
            }
            foreach ($oldImages as $id => $image) {
                ActivityImage::findOne($id)->delete();
            }
            $transaction->commit();
            return $activity->id;
        }

        $transaction->rollBack();
        return false;
    }


}