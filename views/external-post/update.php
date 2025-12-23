<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ExternalPost $model */

$this->title = 'Update External Post: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'External Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="external-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
