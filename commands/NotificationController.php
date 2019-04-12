<?php


namespace app\commands;


use app\base\INotificaztion;
use app\components\ActivityDbComponent;
use app\components\NotificationComponent;
use app\models\Activity;
use app\models\ActivityRecord;
use yii\console\Controller;
use yii\helpers\Console;

class NotificationController extends Controller
{
    public $name;

    public $from;

    public function options($actionID)
    {
        return [
//            'name',
            'from'
        ];
    }

    public function optionAliases()
    {
        return [
            'n'=>'name',
            'f'=>'from'
        ];
    }

    public function actionTest(){

        echo 'this is terminal '.PHP_EOL;
//        print_r($args);
        echo $this->ansiFormat($this->name,Console::FG_GREEN).PHP_EOL;
    }

    public function actionSendNotifications(){

        /** @var ActivityDbComponent $repository */
        $repository=\Yii::createObject(['class'=>ActivityDbComponent::class,'record_model_class'=>ActivityRecord::class,'model_class'=>Activity::class]);
        $activities=$repository->getActivityForNotification($this->from);

//        /** @var NotificationComponent $notififcation */
//        $notififcation=\Yii::createObject(['class'=>NotificationComponent::class,
//            'mailer' => \Yii::$app->mailer]);

        print_r($activities);
        $notififcation=\Yii::$container->get('notification');

        $notififcation->sendNotifications($activities);

    }
}