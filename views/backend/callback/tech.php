<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Callback */

$this->title = 'Технические заявки';
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="callback-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            'id',
            'name',
            'phone',
            'email',
            'question',
            'answer',
            'date_q',
            'date_a',
            'answer_author',
            'ip',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width:70px; text-align:center;'],
                'buttons'=>[
                    'answer'=>function ($url, $model) {
                        $url=Yii::$app->getUrlManager()->createUrl(['backend/callback/answer','id'=>$model['id']]);
                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url,
                            ['title' => Yii::t('app', 'Answer')]);
                    }
                ],
                'template' => '{answer} {view} {delete}',
            ],
        ],

    ]); ?>
</div>
