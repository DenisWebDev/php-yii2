<?php


namespace app\base;


interface INotificaztion
{
    /**
     * @param $activities array['id','email']
     * @return mixed
     */
    public function sendNotifications($activities);
}