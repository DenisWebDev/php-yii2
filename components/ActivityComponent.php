<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 23:41
 */

namespace app\components;

use app\behaviors\LogMyBehavior;
use app\models\Activity;
use yii\base\Component;
use yii\web\UploadedFile;

class ActivityComponent extends Component
{
    public $model_class;

    const EVENT_LOAD_IMAGES='load_imaged';

    public function behaviors()
    {
        return [
            LogMyBehavior::class
        ];
    }

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
        return \Yii::createObject([
            'class' => \Yii::$app->params['activityStorageComponent']
        ]);
    }

    public function createActivity(&$model, $post) {
        /** @var Activity $model */
        if ($model->load($post)) {
            $model->images = UploadedFile::getInstances($model, 'images');
            $model->user_id = \Yii::$app->user->identity->getId();
            if ($model->validate()) {
                if ($this->loadImages($model)) {
                    $model->convertFormDateToDb();
                    if ($id = $this->getStorage()->add($model)) {
                        return $id;
                    }
                    $model->convertDbDateToForm();
                }
            }
        }
        return false;
    }

    private function loadImages($model)
    {
        $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
        foreach ($model->images as &$image) {
            if ($file = $component->saveUploadedImage($image)) {
                $this->trigger(self::EVENT_LOAD_IMAGES);
//                $this->on(self::EVENT_LOAD_IMAGES,func)
                $image = basename($file);
            }
        }
        return true;
    }

    public function getActivity($id)
    {
        /** @var Activity $model */
        $model = $this->getModel();
        $model = $this->getStorage()->get($model, $id);
        $model->convertDbDateToForm();
        return $model;
    }

}