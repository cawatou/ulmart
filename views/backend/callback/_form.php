<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Callback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="callback-form">
    <p><b>#<?=$model->id?></b></p>

    <p><b><?=($model->type == 'T')?"Технический вопрос":"Вопрос об акции";?></b></p>

    <p><b>Время создания обращения:</b></p>
    <p><?=$model->date_q?></p>

    <p><b>Вопрос:</b></p>
    <p><?=$model->question?></p>

    <p><b>Время ответа на обращение:</b></p>
    <p><?=$model->date_a?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer')->textArea(['maxlength' => true]) ?>

    <input checked class="radio_btn" type="radio" name="type" value="T" id="tex">
    <span>технический</span>

    <input class="radio_btn" type="radio" name="type" value="S" id="about">
    <span>по акции</span>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Ответить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
