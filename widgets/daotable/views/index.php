<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2019
 * Time: 19:57
 */

use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $data array  */

?>
<table class="table table-bordered small">
    <tr>
        <?php foreach ($data[0] as $k => $v): ?>
            <td><?= Html::encode($k) ?></td>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($data as $v): ?>
        <tr>
            <?php foreach ($v as $_v): ?>
                <td><?= Html::encode($_v) ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
