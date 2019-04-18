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
<p>
    <a href="<?= Html::encode(Url::to(['/activity/create'])) ?>" class="btn btn-primary">
        <?= Yii::t('app', 'Добавить событие') ?>
    </a>
</p>
<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model
]) ?>
