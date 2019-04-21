<?php

namespace app\commands;


use app\components\ActivityBaseComponent;
use app\components\ActivityComponent;
use app\components\NotificationComponent;
use yii\console\Controller;

class NotificationController extends Controller
{
    public $day;
    public $limit;
    public $email;

    public function options($actionID)
    {
        return ['day', 'limit', 'email'];
    }

    public function optionAliases()
    {
        return [
            'd' => 'day',
            'l' => 'limit',
            'e' => 'email'
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionSend()
    {
        if ($this->day) {
            $day = \DateTime::createFromFormat('Y-m-d', $this->day);
        } else {
            $day = new \DateTime();
        }


        /** @var ActivityComponent $component */
        $component = \Yii::$app->activity;

        $activities = $component->getActivities([
            'email' => $this->email,
            'date_start_from' => $day->format('Y-m-d 00:00:00'),
            'date_start_to' => $day->add(new \DateInterval('P1D'))
                ->format('Y-m-d 00:00:00'),
            'use_notification' => 1,
            'limit' => $this->limit
        ]);

        /** @var NotificationComponent $notification */
        $notification = \Yii::$container->get('notification');

        $notification->sendNotifications($activities);


    }

}