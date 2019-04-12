<?php


namespace app\config;


use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class PreConf implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        \Yii::$container->set(MailerInterface::class,function (){
            return \Yii::$app->mailer;
        });
    }
}