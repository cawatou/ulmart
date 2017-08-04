<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Callback */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Callbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="callback-view">
    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'email:email',
            'question',
            'answer',
            'date_q',
            'date_a',
            'answer_author',
            'type',
            'ip',
        ],
    ]) ?>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
