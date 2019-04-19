<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\ActivityForm
 */
?>

<h2 class="text-center">
    <?= Yii::t('app', 'Редактирование события #').$model->id ?>
</h2>

<?= $this->render('_form', ['model' => $model]) ?>

