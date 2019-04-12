<?php



/* @var $this \yii\web\View */
/* @var $data  */
?>
<table class="table table-bordered small">
    <tr>
        <?php foreach ($data[0] as $k => $v): ?>
            <td><?= \yii\bootstrap\Html::encode($k) ?></td>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($data as $v): ?>
        <tr>
            <?php foreach ($v as $_v): ?>
                <td><?= \yii\bootstrap\Html::encode($_v) ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
