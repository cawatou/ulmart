<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CertificateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список сертификатов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Certificate', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'emptyText'=>'Ничего не найдено',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'promo_code',
            'type',
            'value',
            'status',
            'issume_date',
           /* 'code.name',
            'code.phone',
            'code.email',
            'code.check_number',
            'code.code',*/
        ],
    ]); ?>
</div>
