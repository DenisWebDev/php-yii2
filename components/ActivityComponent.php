<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2019
 * Time: 0:22
 */

namespace app\components;


use app\base\IActivityStorage;
use app\models\ActivityForm;
use yii\base\Component;
use yii\base\UserException;

class ActivityComponent extends Component
{
    public $activityModel;

    public $activityFormModel;

    private $storage;

    public function __construct(IActivityStorage $storage, array $config = [])
    {
        $this->storage = $storage;
        parent::__construct($config);
    }

    public function getActivityFormModel() {
        return new ActivityForm();
    }


    /**
     * @param ActivityForm $model
     * @return bool
     * @throws UserException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function createActivity($model) {
        if (!$model->validate() or !$this->loadImages($model)) {
            return false;
        }

        if ($id = $this->storage->save($model)) {
            return $id;
        }

        throw new UserException('Не удалось сохранить событие');
    }

    /**
     * @param $model ActivityForm
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    private function loadImages($model)
    {
        $component = \Yii::createObject([
            'class' => ImageLoaderComponent::class
        ]);

        foreach ($model->images as &$image) {
            if ($file = $component->saveUploadedImage($image)) {
                $image = basename($file);
                continue;
            }
            $model->addError('images', 'Не удалось сохранить картинку '.$image->name);
            return false;
        }

        return true;

    }



}