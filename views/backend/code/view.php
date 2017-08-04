<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Code */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?/*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'current_step',
            'time_s1',
            'time_s2',
            'time_s3',
            'check_number',
            'name',
            'phone',
            'email:email',
            'answers_count',
            'activate_date',
            'promo_code',
            'ip',
        ],
    ]) ?>

</div>
