<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.04.2019
 * Time: 0:31
 */

/* @var $this \yii\web\View */
/* @var $model \app\modules\auth\models\AuthForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>

<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <h2><?= Yii::t('app', 'Вход') ?></h2>
        <?php $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Войти', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <p><b>admin@site.ru / 123456</b></p>
        <p><b>user@site.ru / 123456</b></p>

        <?php ActiveForm::end(); ?>


    </div>
</div>
