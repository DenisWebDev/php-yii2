<?php

namespace app\components;


use app\base\ILogger;
use app\base\INotification;
use yii\base\Component;
use yii\console\Application;
use yii\mail\MailerInterface;

class NotificationComponent extends Component implements INotification
{
    private $mailer;

    private $logger;

    private $sendError;

    public function __construct(MailerInterface $mailer, ILogger $logger, $config = [])
    {
        $this->mailer = $mailer;

        $this->logger = $logger;

        parent::__construct($config);
    }

    public function sendNotifications($activities)    {

        foreach ($activities as $activity) {
            if ($this->sendMail(
                $activity->user->email,
                $activity->title,
                $activity->date_start,
                $activity->description)
            ) {
                if (\Yii::$app instanceof Application) {
                    $this->logger->success('Успешно отправлено письмо на '.$activity->user->email);
                }
            } else {
                if (\Yii::$app instanceof Application) {
                    $this->logger->error('Ошибка отправки на '.$activity->user->email);
                    if (YII_DEBUG) {
                        $this->logger->error($this->sendError);
                    }
                }
            }
        }
    }

    /**
     * @param $email
     * @param $title
     * @param $date_start
     * @param $description
     * @return bool;
     */
    private function sendMail($email, $title, $date_start, $description)
    {
        if (YII_DEBUG) {
//            return true;
            $email = \Yii::$app->params['adminEmail'];
        }

        try {
            return $this->mailer->compose('notification', [
                'title' => $title,
                'date_start' => $date_start,
                'description' => $description
            ])
                ->setTo($email)
                ->setSubject('Событие запланировано на сегодня')
                ->setFrom(\Yii::$app->params['mailerFrom'])
                ->send();
        } catch (\Swift_SwiftException $e) {
            $this->sendError = $e->getMessage();
            return false;
        }

    }

}