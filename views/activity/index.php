<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\ActivitySearch
 * @var $provider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<h2 class="text-center">
    <?= Yii::t('app', 'События') ?>
</h2>
<p>
    <a href="<?= Html::encode(Url::to(['/activity/create'])) ?>" class="btn btn-primary">
        <?= Yii::t('app', 'Добавить событие') ?>
    </a>
</p>
<?php
    $columns = [
        'id',
        [
            'attribute' => 'title',
            'label' => Yii::t('app', 'Название'),
            'value' => function($model) {
                return Html::a(Html::encode($model->title),
                    ['activity/update', 'id' => $model->id]
                );
            },
            'format' => 'html'
        ],
        [
            'label' => Yii::t('app', 'Даты'),
            'value' => function($model) {
                ob_start();
                echo \DateTime::createFromFormat('Y-m-d H:i:s', $model->date_start)
                    ->format('d.m.Y');
                if ($model->date_end) {
                    echo '-'.\DateTime::createFromFormat('Y-m-d H:i:s', $model->date_end)
                            ->format('d.m.Y');
                }
                return ob_get_clean();
            },
            'format' => 'html'
        ],
        [
            'label' => Yii::t('app', 'Дополнительно'),
            'value' => function($model) {
                ob_start();
                if ($model->is_blocked) {
                    echo 'Блокирующее<br>';
                }
                if ($model->use_notification) {
                    echo 'С уведомлением<br>';
                }
                return ob_get_clean();
            },
            'format' => 'html'
        ]
    ];
    if ($model->showUser) {
        $columns[] = [
            'attribute' => 'user.email',
            'label' => Yii::t('app', 'Пользователь')
        ];
    }
?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'columns' => $columns
]) ?>
