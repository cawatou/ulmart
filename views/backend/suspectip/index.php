<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SuspectIpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заблокированные ip';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suspect-ip-index">

    <h1><?= Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Suspect Ip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText'=>'Ничего не найдено',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'ip',
            'date',
            //'lock_type',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
