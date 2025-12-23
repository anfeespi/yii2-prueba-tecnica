<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ExternalPost $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'External Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="external-post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'external_id',
            'user_id',
            'title',
            'body:ntext',
            [
                'attribute' => 'payload',
                'format' => 'raw',
                'value' => function ($model) {
                    $json = json_decode($model->payload);
                    return '<pre>' . json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';
                },
            ],
            'hash',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
