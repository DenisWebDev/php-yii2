<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.04.2019
 * Time: 21:52
 */

namespace app\components;


use app\models\Activity;
use yii\base\Component;
use yii\web\UploadedFile;

abstract class ActivityBaseComponent extends Component
{
    public $model_class;

    abstract protected function insert($model);

    abstract public function getActivity($id);

    abstract public function getActivities($options = []);

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->model_class) {
            throw new \Exception('Need model_class param');
        }
    }

    public function getModel() {
        /** @var Activity $model */
        $model = new $this->model_class;
        return $model;
    }

    /**
     * @param $model
     * @param $post
     * @param $user_id
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function createActivity(&$model, $post, $user_id) {
        /** @var Activity $model */
        if ($model->load($post)) {
            $model->images = UploadedFile::getInstances($model, 'images');
            $model->user_id = $user_id;
            if ($model->validate()) {
                if ($this->loadImages($model)) {
                    $model->convertFormDateToDb();
                    if ($id = $this->insert($model)) {
                        return $id;
                    }
                    $model->convertDbDateToForm();
                }
            }
        }
        return false;
    }

    /**
     * @param $model
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    private function loadImages($model)
    {
        $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
        foreach ($model->images as &$image) {
            if ($file = $component->saveUploadedImage($image)) {
                $image = basename($file);
            }
        }
        return true;
    }


}