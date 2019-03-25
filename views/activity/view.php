<?php
/**
 * Created by PhpStorm.
 * User: Talisman
 * Date: 25.03.2019
 * Time: 20:34
 * @var $model \app\models\Activity
 */
?>
<div class="row">
    <div class="col-md-12">
        <?=\yii\helpers\Html::tag('p','Описание: '.$model->description)?>
        <p>Название:<strong><?=\yii\helpers\Html::encode($model->title)?></strong></p>
        <p><?=\yii\helpers\Html::img('/images/'.$model->file,['width'=>150])?></p>
    </div>
</div>
