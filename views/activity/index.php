<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\ActivitySearch
 * @var $provider \yii\data\ActiveDataProvider
 * @var $columns array
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
<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'columns' => $columns
]) ?>
