<?php

use app\models\ExternalPost;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ExternalPostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'External Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create External Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('🔄 Sincronizar con API', ['sync'], [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'external_id',
            'user_id',
            'title',
            'body:ntext',
            //'payload:ntext',
            //'hash',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ExternalPost $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
