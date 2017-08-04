<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Certificate */
$this->title = 'Сбьрос пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-types">

    <h1><?= Html::encode($this->title) ?></h1>
    <input id="clear_code" value="" type="text">
    <input type="submit" value="Очистить" id="clear_btn">
</div>

