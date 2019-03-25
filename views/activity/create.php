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

$array=['2'=>'val1','two'=>['tr'=>'value sub']];

$db=[['id'=>2,'name'=>'val1'],['id'=>3,'name'=>'val2']];

//    echo isset($array['1'])?$array['1']:'';

    echo \yii\helpers\ArrayHelper::getValue($array,'val2').'<br/>';

    echo \yii\helpers\ArrayHelper::getValue($array,'two.tr');

    $new_db=\yii\helpers\ArrayHelper::map($db,'id',function ($value){
        return \yii\helpers\ArrayHelper::getValue($value,'name').' 1';
    });
    print_r($new_db);
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'activity-create',
            'method' => 'post',
//            'enableAjaxValidation' => true,
        ]); ?>
        <?=\yii\helpers\Html::input('type','name_in','123',['class'=>'form-control']);?>

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

