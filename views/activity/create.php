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
use dosamigos\datepicker\DatePicker;
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'activity-create',
            'method' => 'post'
        ]); ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'date_start')->widget(
            DatePicker::class, [
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
        ]) ?>
        <?= $form->field($model, 'date_end')->widget(
            DatePicker::class, [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]) ?>
        <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' =>'image/*']) ?>
        <?= $form->field($model, 'repeat_type')->dropDownList($model->getRepeatTypes()) ?>
        <?= $form->field($model, 'is_blocked')->checkbox() ?>
        <?= $form->field($model, 'notify_phone', [
            'enableAjaxValidation' => true
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>

