<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\ActivityForm
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use dosamigos\datepicker\DatePicker;

?>
<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <?php $form = ActiveForm::begin([
            'id' => 'activity-create',
            'method' => 'post'
        ]); ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'date_start', [
            'enableAjaxValidation' => true
        ])->widget(
            DatePicker::class, [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]) ?>
        <?= $form->field($model, 'date_end', [
            'enableAjaxValidation' => true
        ])->widget(
            DatePicker::class, [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]) ?>
        <?php foreach ($model->images as $image): ?>
            <?php if (is_string($image)): ?>
                <span>
                    <input type="hidden" name="ActivityForm[savedImages][]" value="<?php echo $image; ?>">
                    <img onclick="$(this).parent().remove();" src="/images/<?php echo $image; ?>" alt="" class="img-thumbnail" style="height: 100px; margin: 5px 0; cursor: pointer;">
                </span>
            <?php endif; ?>
        <?php endforeach; ?>


        <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' =>'image/*']) ?>
        <?= $form->field($model, 'repeat_type_id')->dropDownList($model->getRepeatTypes()) ?>
        <?= $form->field($model, 'is_blocked')->checkbox() ?>
        <?= $form->field($model, 'use_notification')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

