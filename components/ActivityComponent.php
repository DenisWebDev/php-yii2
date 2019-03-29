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

    public function createActivity(&$model, $post):bool {
        /** @var Activity $model */
        if ($model->load($post)) {
            $model->images = UploadedFile::getInstances($model, 'images');
            if ($model->validate()) {
                if ($this->loadImages($model)) {
                    $this->getStorage()->save('activity_demo', $model);
                    return true;
                }
            }
        }
        return false;
    }
}