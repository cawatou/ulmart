<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список всех паролей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Code', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [   

            //'id',
            'code',
            'current_step',
            //'time_s1',
            //'time_s2',
            // 'time_s3',
            'check_number',
            'name',
            'phone',
            'email:email',
            'questions',
            'answers',
            'answers_count',
            'activate_date',
            'promo_code',
            // 'prize',
            // 'ip',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
