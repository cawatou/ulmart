<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = 'Скачать сертификаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a class="download_csv" href='#'>Скачать</a>
    </p>
</div>

