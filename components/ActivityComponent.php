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
use yii\validators\EmailValidator;
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

    public function createActivity(&$model, $post): bool
    {
        /** @var Activity $model */
        if ($model->load($post)) {
            $model->file=UploadedFile::getInstance($model,'file');
            if ($model->validate()) {
                $comp=\Yii::createObject(['class'=>FileServiceComponent::class]);
                if(!empty($file=$comp->saveUploadedFile($model->file))){
                    $model->file=basename($file);
                }
                return true;
            }
        }
        return false;
    }
}