<?php



/* @var $this \yii\web\View
 * @var $users array
 */
?>
<div class="row">
    <div class="col-md-6">
        <pre>
            <?=print_r($users)?>
        </pre>
    </div>
    <div class="col-md-6">
        <pre>
            <?=print_r($acitvityUser)?>
        </pre>
    </div>
    <div class="col-md-6">
        <pre>
            <?=print_r($user);?>
        </pre>
    </div>
    <div class="col-md-6">
        <pre>
            Кол-во:<?=$cnt;?>
        </pre>
    </div>
    <div class="col-md-6">
        <?php foreach ($reader as $item):?>
         <?=\yii\helpers\ArrayHelper::getValue($item,'title');?>
        <?php endforeach;?>
    </div>
</div>
