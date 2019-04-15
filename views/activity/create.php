<?php

/*
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 */

use yii\bootstrap\Html;
use dosamigos\datepicker\DatePicker;
?>

<h2 class="text-center">
    <?=Yii::t('app','Новое событие') ?>
</h2>

<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'activity-create',
            'method' => 'post'
        ]); ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'date_start', [
            'enableAjaxValidation' => true
        ])->widget(
            DatePicker::class, [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]) ?>
        <?= $form->field($model, 'date_end', [
            'enableAjaxValidation' => true
        ])->widget(
            DatePicker::class, [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]) ?>
        <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' =>'image/*']) ?>
        <?= $form->field($model, 'repeat_type_id')->dropDownList($model->getRepeatTypes()) ?>
        <?= $form->field($model, 'is_blocked')->checkbox() ?>
        <?= $form->field($model, 'use_notification')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>

