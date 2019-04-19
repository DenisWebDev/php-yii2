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

        $activity->setAttributes($model->getAttributes($model->commonFields), false);

        $activity->date_start = \DateTime::createFromFormat('d.m.Y', $model->date_start)
            ->format('Y-m-d H:i:s');
        if ($model->date_end) {
            $activity->date_end = \DateTime::createFromFormat('d.m.Y', $model->date_end)
                ->format('Y-m-d H:i:s');
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
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
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->rollBack();
        return false;
    }


    public function find($id)
    {
        return Activity::findOne($id);
    }

    public function loadForm($id)
    {
        if ($activity = $this->find($id)) {
            $form = new ActivityForm();

            $form->setAttributes($activity->getAttributes($form->commonFields), false);

            $form->date_start = \DateTime::createFromFormat('Y-m-d H:i:s', $activity->date_start)
                ->format('d.m.Y');
            if ($activity->date_end) {
                $form->date_end = \DateTime::createFromFormat('Y-m-d H:i:s', $activity->date_end)
                    ->format('d.m.Y');
            }
            foreach ($activity->activityImages as $image) {
                $form->images[] = $image['name'];
            }
            $form->id = $activity->id;

            return $form;
        }

        return false;
    }
}