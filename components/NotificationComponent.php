<?php

namespace app\components;


use yii\base\Component;
use yii\console\Application;
use yii\helpers\Console;
use yii\mail\MailerInterface;

class NotificationComponent extends Component
{
    /** @var MailerInterface */
    public $mailer;
    private $sendError;

    public function sendNotifications($activities)    {

        foreach ($activities as $activity) {
            if ($this->sendMail(
                $activity->user->email,
                $activity->title,
                $activity->date_start,
                $activity->description)
            ) {
                if (\Yii::$app instanceof Application) {
                    echo Console::ansiFormat('Успешно отправлено письмо на '.$activity->user->email,
                            [Console::FG_GREEN]).PHP_EOL;
                }
            } else {
                if (\Yii::$app instanceof Application) {
                    echo Console::ansiFormat('Ошибка отправки на '.$activity->user->email,
                            [Console::FG_RED]).PHP_EOL;
                    if (YII_DEBUG) {
                        echo Console::ansiFormat($this->sendError,
                                [Console::FG_RED]).PHP_EOL;
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
        }

    }

}