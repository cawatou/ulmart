<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Certificate */
$this->title = 'Общая статистика';
$this->params['breadcrumbs'][] = $this->title;
//echo "<pre>".print_r($clients, 1)."</pre>";
?>
<div class="certificate-types">

    <h1><?= Html::encode($this->title) ?></h1>

    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <tr>
                <th>Количество клиентов (число уникальных e-mail)</th>
                <td><?=(isset($clients))?$clients[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Количество чеков, принявших участие в акции</th>
                <td><?=(isset($count_check))?$count_check[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Количество паролей c ответами (0-2)</th>
                <td><?=(isset($count1_2))?$count1_2[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Количество паролей c ответами (3-5)</th>
                <td><?=(isset($count3_5))?$count3_5[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Количество паролей c ответами (6-8)</th>
                <td><?=(isset($count6_8))?$count6_8[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Количество паролей c ответами (9-10)</th>
                <td><?=(isset($count9_10))?$count9_10[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Выигранных канцелярских товаров</th>
                <td><?=(isset($count_office))?$count_office[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Выигранных настольных игр</th>
                <td><?=(isset($count_game))?$count_game[0]['count']:'0';?></td>
            </tr>
            <tr>
                <th>Выигранных ноутбуков</th>
                <td><?=(isset($count_comp))?$count_comp[0]['count']:'0';?></td>
            </tr>
        </tbody>
    </table>
</div>
