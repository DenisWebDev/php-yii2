<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 18:42
 */

/*
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 */

use yii\bootstrap\Html;

?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'activity-create',
            'method' => 'post',
//            'enableAjaxValidation' => true,
        ]); ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'date_start'); ?>
        <?= $form->field($model, 'repeat_type')->dropDownList($model->getRepeatTypes()) ?>
        <?= $form->field($model, 'is_blocked')->checkbox() ?>
        <?= $form->field($model, 'use_notification')->checkbox(); ?>
        <?= $form->field($model, 'email', [
            'enableAjaxValidation' => true,
            'enableClientValidation' => false]); ?>
        <?=$form->field($model,'repeat_email');?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?=$form->field($model,'file')->fileInput()?>
        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>

