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
    public $modelFormClass;

    private $storage;

    public function __construct(IActivityStorage $storage, array $config = [])
    {
        $this->storage = $storage;
        parent::__construct($config);
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->modelFormClass) {
            throw new \Exception('Need modelFormClass param');
        }
    }

    /**
     * @param null|integer $id
     * @return bool|ActivityForm
     */
    public function getActivityFormModel($id = null) {
        if ($id === null) {
           return new $this->modelFormClass();
        }
        if ($form = $this->storage->loadForm($id)) {
            return $form;
        }
        return false;
    }


    /**
     * @param ActivityForm $model
     * @return bool
     * @throws UserException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function saveActivity(ActivityForm $model) {
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
    private function loadImages(ActivityForm $model)
    {
        $component = \Yii::createObject([
            'class' => ImageLoaderComponent::class
        ]);

        foreach ($model->images as $k => $image) {
            if ($file = $component->saveUploadedImage($image)) {
                $model->images[$k] = basename($file);
                continue;
            }
            $model->addError('images', 'Не удалось сохранить картинку '.$image->name);
            return false;
        }

        foreach ($model->savedImages as $image) {
            if (is_file(\Yii::getAlias('@webroot/images/'.$image))) {
                $model->images[] = $image;
            }
        }

        return true;

    }

    public function find($id)
    {
        return $this->storage->find($id);
    }

    public function getActivities($options = [])
    {
        return $this->storage->getActivities($options);
    }



}