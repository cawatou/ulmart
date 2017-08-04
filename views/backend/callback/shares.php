<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Callback */

$this->title = 'Вопросы по акции';
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="callback-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'emptyText'=>'Ничего не найдено',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                'label' => 'Имя',
            ],
            [
                'attribute'=>'phone',
                'label' => 'Телефон',
            ],
            [
                'attribute'=>'email',
                'label' => 'Email',
            ],
            [
                'attribute'=>'question',
                'label' => 'Вопрос',
            ],
            [
                'attribute'=>'answer',
                'label' => 'Ответ',
            ],
            [
                'attribute'=>'date_q',
                'label' => 'Дата вопроса',
            ],
            [
                'attribute'=>'date_a',
                'label' => 'Дата ответа',
            ],
            [
                'attribute'=>'answer_author',
                'label' => 'Автор ответа',
            ],
            //'type',
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
