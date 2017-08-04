<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Code */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'current_step')->textInput() ?>

    <?= $form->field($model, 'time_s1')->textInput() ?>

    <?= $form->field($model, 'time_s2')->textInput() ?>

    <?= $form->field($model, 'time_s3')->textInput() ?>

    <?= $form->field($model, 'check_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer_count')->textInput() ?>

    <?= $form->field($model, 'activate_date')->textInput() ?>

    <?= $form->field($model, 'promo_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prize')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
