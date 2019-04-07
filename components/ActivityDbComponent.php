<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.04.2019
 * Time: 21:55
 */

namespace app\components;


use app\models\ActivityRecord;

class ActivityDbComponent extends ActivityBaseComponent
{
    public $record_model_class;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->record_model_class) {
            throw new \Exception('Need record_model_class param');
        }
    }

    protected function getRecordModel() {
        /** @var ActivityRecord $model */
        $model = new $this->record_model_class;
        return $model;
    }

    protected function insert($model)
    {
        $record = $this->getRecordModel();
        $record->setAttributes($model->attributes);
        if ($record->save()) {
            return $record->id;
        }
        return false;
    }

    public function getActivity($id)
    {
        $record = $this->getRecordModel();
        if ($data = $record::find()->where(['id' => $id])->one()) {
            $model = $this->getModel();
            $model->setAttributes($data->attributes, false);
            $model->convertDbDateToForm();
            return $model;
        }
        return null;
    }

    public function getActivities($options = [])
    {
        $result = [];

        $record = $this->getRecordModel();
        if ($data = $record::find()->all()) {
            foreach ($data as $record) {
                $model = $this->getModel();
                $model->setAttributes($record->attributes, false);
                $model->convertDbDateToForm();
                $result[] = $model->getAttributes();
            }
        }

        return $result;
    }
}