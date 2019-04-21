<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.04.2019
 * Time: 0:23
 */

namespace app\base;


interface INotification
{
    public function sendNotifications($activities);

}