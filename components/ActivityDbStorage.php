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
use yii\helpers\ArrayHelper;

class ActivityDbStorage extends Component implements IActivityStorage
{
    public $modelClass;

    public $modelFormClass;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->modelClass) {
            throw new \Exception('Need modelClass param');
        }

        if (!$this->modelFormClass) {
            throw new \Exception('Need modelFormClass param');
        }
    }


    /**
     * @return Activity
     */
    public function getModel()
    {
        return new $this->modelClass();
    }

    /**
     * @return ActivityForm
     */
    public function getFormModel()
    {
        return new $this->modelFormClass();
    }

    /**
     * @param $model
     * @return bool|int
     * @throws \Throwable
     */
    public function save(ActivityForm $model)
    {
        if ($model->id) {
            $activity = $this->getModel()::findOne($model->id);
            if ($activity === null) {
                return false;
            }
        } else {
            $activity = $this->getModel();
        }

        $activity->setAttributes($model->getAttributes($model->commonFields), false);

        $activity->date_start = $model->getDateStartDateTime()->format('Y-m-d H:i:s');

        if ($date = $model->getDateEndDateTime()) {
            $activity->date_end = $date->format('Y-m-d H:i:s');
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
        return $this->getModel()::findOne($id);
    }

    public function loadForm($id)
    {
        if ($activity = $this->find($id)) {
            $form = $this->getFormModel();

            $form->setAttributes($activity->getAttributes($form->commonFields), false);

            $form->setDateStartFromDateTime(\DateTime::createFromFormat('Y-m-d H:i:s', $activity->date_start));

            if ($activity->date_end) {
                $form->setDateEndFromDateTime(\DateTime::createFromFormat('Y-m-d H:i:s', $activity->date_end));
            }

            foreach ($activity->activityImages as $image) {
                $form->images[] = $image['name'];
            }
            $form->id = $activity->id;

            return $form;
        }

        return false;
    }

    public function getActivities($options = [])
    {
        $query = $this->getModel()::find();

        $query->leftJoin('user', 'user.id = activity.user_id');

        $query->andFilterWhere(['=', 'user.email',
            ArrayHelper::getValue($options, 'email')]);

        $query->andFilterWhere(['>=', 'date_start',
            ArrayHelper::getValue($options, 'date_start_from')]);

        $query->andFilterWhere(['<', 'date_start',
            ArrayHelper::getValue($options, 'date_start_to')]);

        $query->andFilterWhere(['=', 'use_notification',
            ArrayHelper::getValue($options, 'use_notification')]);

        $query->with('user');

        if ($limit = ArrayHelper::getValue($options, 'limit')) {
            $query->limit($limit);
        }
//        echo $query->createCommand()->rawSql;
//        exit();

        $data = $query->all();


        return $data ? $data : [];
    }
}