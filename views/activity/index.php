<?php

/*
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<p>
    <a href="<?= Html::encode(Url::to(['/activity/create'])) ?>" class="btn btn-primary">
        <?= Yii::t('app', 'Добавить событие') ?>
    </a>
</p>
