<?php


namespace app\components;


use app\base\ILogger;
use app\base\INotificaztion;
use yii\console\Application;
use yii\helpers\Console;
use yii\mail\MailerInterface;

class Notification implements INotificaztion
{

    /** @var MailerInterface */
    private $mailer;

    private $logger;

    public function __construct(MailerInterface $mailer, ILogger $logger)
    {
        $this->mailer=$mailer;

        $this->logger=$logger;
    }

    public function sendNotifications($activities)
    {
        foreach ($activities as ['email'=>$email,
                 'title'=>$title,
                 'date_start'=>$date_start,
                 'description'=>$description]){
            if($this->sendMail($email,$title,$date_start,$description)){
                $this->logger->log('success '.$email.PHP_EOL);
            }else{
                $this->logger->log('ОШибка');
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
    private function sendMail($email,$title,$date_start,$description){
        return $this->mailer->compose('notification',[
            'title'=>$title,
            'date_start'=>$date_start,
            'description'=>$description])
            ->setTo($email)
            ->setSubject('Событие запланировано на сегодня')
            ->setFrom('geekbrains@onedeveloper.ru')
            ->send();
    }
}