<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 31.03.2019
 * Time: 14:28
 */

/**
 * @var $this \yii\web\View
 * @var $data array
 * @var $rand_user_id integer
 * @var $rand_user_email string
 */

?>
<p><a href="<?= \yii\helpers\Url::to(['dao/add']) ?>">Наполнить данными</a></p>
<?php if ($data): ?>
    <p>
        <a href="<?= \yii\helpers\Url::to([
            'dao/index',
            'user_id' => $rand_user_id
        ]) ?>">
            Найти все события пользователя ID <?= $rand_user_id ?>
        </a>
    </p>
    <p>
        <a href="<?= \yii\helpers\Url::to([
            'dao/index',
            'user_email' => $rand_user_email
        ]) ?>">
            Найти все события пользователя email <?= $rand_user_email ?>
        </a>
    </p>
    <p><a href="<?= \yii\helpers\Url::to(['dao/clear']) ?>">Очистить данные</a></p>
    <p>Всего событий: <?= count($data) ?></p>
    <?=\app\widgets\daotable\DaoTableWidget::widget(['activities' => $data]);?>
<?php endif; ?>