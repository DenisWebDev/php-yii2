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
            'method' => 'post'
        ]); ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'date_start')->input('date') ?>
        <?= $form->field($model, 'is_blocked')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php \yii\bootstrap\ActiveForm::end(); ?>

        <br><br>
        <?= Yii::getAlias('@logs/error.log') ?>
    </div>
</div>

