<?php

use app\models\ActivitySearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:22
 */

/**
 * @var $this \yii\web\View
 * @var $model ActivitySearch
 * @var $provider ActiveDataProvider
 */
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'tableOptions' => [
        'class' => 'table table-bordered table-hover'
    ],
    'rowOptions' => function($model, $key, $index, $grid) {
        $class = $index%2 ? 'odd' : 'even';
        return ['class' => $class, 'index' => $index, 'key' => $key];
    },
    'layout' => "{summary}\n{pager}\n{items}\n{pager}",
    'columns' => [
        ['class' => SerialColumn::class],
        'id',
        'email',
        'user.email',
        [
            'attribute' => 'title',
            'value' => function($model) {
                return Html::a(Html::encode($model->title), ['activity/view', 'id' => $model->id]);
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'date_start',
            'value' => function($model) {
                return Yii::$app->formatter->asDate($model->date_start);
            }
        ]
    ]
]) ?>
