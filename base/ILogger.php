<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.04.2019
 * Time: 0:34
 */

namespace app\base;


interface ILogger
{
    public function success($message);

    public function error($message);
}