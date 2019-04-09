<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2019
 * Time: 0:34
 */

namespace app\commands;


use app\components\ActivityBaseComponent;
use app\components\NotificationComponent;
use yii\console\Controller;

class NotificationController extends Controller
{
    public $day;
    public $limit;

    public function options($actionID)
    {
        return ['day', 'limit'];
    }

    public function optionAliases()
    {
        return [
            'd' => 'day',
            'l' => 'limit'
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionSendNotifications()
    {
        if ($this->day) {
            $day = \DateTime::createFromFormat('Y-m-d', $this->day);
        } else {
            $day = new \DateTime();
        }


        /** @var ActivityBaseComponent $component */
        $component = \Yii::$app->activity;

        $activities = $component->getActivities([
            'date_start_from' => $day->format('Y-m-d 00:00:00'),
            'date_start_to' => $day->add(new \DateInterval('P1D'))
                ->format('Y-m-d 00:00:00'),
            'use_notification' => 1,
            'limit' => $this->limit
        ]);

        /** @var NotificationComponent $notification */
        $notification = \Yii::createObject([
            'class' => NotificationComponent::class,
            'mailer' => \Yii::$app->mailer
        ]);

        $notification->sendNotifications($activities);


    }

}