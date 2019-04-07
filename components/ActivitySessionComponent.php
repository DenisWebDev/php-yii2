<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.04.2019
 * Time: 0:05
 */

namespace app\components;


class ActivitySessionComponent extends ActivityBaseComponent
{

    /**
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    protected function insert($model)
    {
        $data = $model->attributes;

        $storage_data = $this->getData('activity');

        $keys = array_keys($storage_data);
        $id = reset($keys) + 1;

        $data['id'] = $id;
        $data['date_add'] = (new \DateTime())->format('Y-m-d H:i:s');

        $storage_data[$id] = $data;

        $this->setData('activity', $storage_data);

        return $id;
    }

    public function getActivity($id)
    {
        $storage_data = $this->getData('activity');
        if (array_key_exists($id, $storage_data)) {
            $model = $this->getModel();
            $model->setAttributes($storage_data[$id], false);
            $model->convertDbDateToForm();
            return $model;
        }
    }

    public function getActivities($options = [])
    {
        $result = [];

        if ($data = $this->getData('activity')) {
            foreach ($data as $record) {
                $model = $this->getModel();
                $model->setAttributes($record, false);
                $model->convertDbDateToForm();
                $result[] = $model->getAttributes();
            }
        }

        return $result;
    }

    private function getData($table)
    {
        return \Yii::$app->session->get('storage_'.$table, []);
    }

    private function setData($table, $data) {
        \Yii::$app->session->set('storage_'.$table, $data);
    }
}