<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SuspectCode */

$this->title = 'Create Suspect Code';
$this->params['breadcrumbs'][] = ['label' => 'Suspect Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suspect-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
