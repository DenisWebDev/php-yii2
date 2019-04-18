<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\ActivityForm
 */
?>

<h2 class="text-center">
    <?= Yii::t('app', 'Новое событие') ?>
</h2>

<?= $this->render('_form', ['model' => $model]) ?>

