<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CodeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'current_step') ?>

    <?= $form->field($model, 'time_s1') ?>

    <?= $form->field($model, 'time_s2') ?>

    <?php // echo $form->field($model, 'time_s3') ?>

    <?php // echo $form->field($model, 'check_number') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'answer_count') ?>

    <?php // echo $form->field($model, 'activate_date') ?>

    <?php // echo $form->field($model, 'promo_code') ?>

    <?php // echo $form->field($model, 'prize') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
