<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Certificate */
$this->title = 'Типы сертификатов';
$this->params['breadcrumbs'][] = $this->title;
//echo "<pre>".print_r($result, 1)."</pre>";
?>
<div class="certificate-types">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><a href="">Тип сертификата</a></th>
                    <th><a href="">Общее количество сертификатов</a></th>
                    <th><a href="">Выданых сертификатов</a></th>
                    <th><a href="">Остаток сертификатов</a></th>
                </tr>
            </thead>
            <tbody>
                <?foreach($result as $certificate):
                    if($certificate['type'] == 'A') $type = 'Канцелярские товары';
                    if($certificate['type'] == 'B') $type = 'Настольные игры';
                    if($certificate['type'] == 'C') $type = 'Ноутбуки';
                    $rest = intval($certificate['count']) - intval($certificate['activeted']);
                    ?>
                    <tr data-key="1">
                        <td><?=$type?></td>
                        <td><?=$certificate['count']?></td>
                        <td><?=$certificate['activeted']?></td>
                        <td><?=$rest?></td>
                    </tr>
                <?endforeach?>
            </tbody>
        </table>
    </div>
</div>
