<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:22
 */

/* @var $this \yii\web\View
 * @var $model \app\models\Activity
 */

echo $model->getDateCreated();
echo '<br>';
echo \yii\bootstrap\Html::tag('pre', print_r($model->attributes, true));