<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:22
 */

/* @var $this \yii\web\View
 * @var $model \app\models\ActivitySearch
 * @var $provider \yii\data\ActiveDataProvider
 */
?>

<?=\yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'tableOptions' => [
        'class'=>'table-hover table table-bordered'
    ],
    'rowOptions' => function($model,$key,$index,$grid){
        $class=$index%2?'odd':'even';
        return ['class'=>$class,'index'=>$index,'key'=>$key];
    },
    'layout' => "{summary}\n{pager}\n{items}\n{pager}",
    'columns' => [
        ['class'=>\yii\grid\SerialColumn::class],
        [
            'attribute' => 'id'
        ],
        [
            'attribute' => 'email'
        ],
        [
            'attribute' => 'user.email',

        ],
        [
            'attribute' => 'title',
            'value' => function($model){
                return \yii\helpers\Html::a(\yii\helpers\Html::encode($model->title),['/activity/view','id'=>$model->id]);
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'date_start',
            'value' => function($model){
                return Yii::$app->formatter->asDate($model->date_start);
            }
        ],
        'date_start'
    ]
]);?>
