<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2019
 * Time: 1:51
 */

namespace app\components;


use yii\base\Component;
use yii\console\Application;
use yii\helpers\Console;
use yii\mail\MailerInterface;

class NotificationComponent extends Component
{
    /** @var MailerInterface */
    public $mailer;

    public function sendNotifications($activities)
    {
        foreach ($activities as [
            'email' => $email,
            'title' => $title,
            'date_start' => $date_start,
            'description' => $description
        ]) {
           if ($this->sendMail($email, $title, $date_start, $description)) {
               if (\Yii::$app instanceof Application) {
                   echo Console::ansiFormat('Успешно отправлено письмо на '.$email,
                       [Console::FG_GREEN]).PHP_EOL;
               }
           } else {
               if (\Yii::$app instanceof Application) {
                   echo Console::ansiFormat('Ошибка отправки на '.$email,
                           [Console::FG_RED]).PHP_EOL;
               }
           }
        }
    }

    /**
     * @param $email
     * @param $title
     * @param $date_start
     * @param $description
     * @return bool
     */
    private function sendMail($email, $title, $date_start, $description)
    {
        if (YII_DEBUG) {
//            return true;
            $email = \Yii::$app->params['adminEmail'];
        }
        return $this->mailer->compose('notification', [
                'title' => $title,
                'date_start' => $date_start,
                'description' => $description
            ])
            ->setTo($email)
            ->setSubject('Событие запланировано на сегодня')
            ->setFrom(\Yii::$app->params['mailerFrom'])
            ->send();

    }

}