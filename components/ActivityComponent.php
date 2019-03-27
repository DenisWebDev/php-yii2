<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 23:41
 */

namespace app\components;

use app\models\Activity;
use yii\base\Component;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class ActivityComponent extends Component
{
    public $model_class;

    public function init()
    {
        parent::init();

        if (empty($this->model_class)) {
            throw new \Exception('Need model_class param');
        }
    }

    public function getModel()
    {
        return new $this->model_class;
    }

    private function getStorage()
    {
        return \Yii::createObject(['class' => SessionStorageComponent::class]);
    }

    public function createActivity(&$model, $post):bool {
        /** @var Activity $model */
        if ($model->load($post) && $model->validate()) {
            $model->images = UploadedFile::getInstances($model, 'images');
            if ($this->loadImages($model)) {
                $this->getStorage()->save('activity_demo', $model);
                return true;
            }
        }
        return false;
    }

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

    public function getActivity()
    {
        return $this->getStorage()->get('activity_demo', $this->getModel());
    }
}