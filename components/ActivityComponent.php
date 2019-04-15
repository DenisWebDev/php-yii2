<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2019
 * Time: 0:22
 */

namespace app\components;


use app\base\IActivityStorage;
use app\models\Activity;
use app\models\ActivityForm;
use yii\base\Component;

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

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->activityModel) {
            throw new \Exception('Need activityModel param');
        }

        if (!$this->activityFormModel) {
            throw new \Exception('Need activityFormModel param');
        }
    }

    public function getActivityModel() {
        /** @var Activity $model */
        $model = new $this->activityModel();
        return $model;
    }

    public function getActivityFormModel() {
        /** @var ActivityForm $model */
        $model = new $this->activityFormModel();
        return $model;
    }

    public function createActivity($model) {

    }



}