<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Project $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

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
            'name',
            'description:ntext',
            'owner_user_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <hr>
    <h3>Tareas de este Proyecto</h3>

    <p>
        <?= \yii\helpers\Html::a('Crear Nueva Tarea', 
            ['task/create', 'project_id' => $model->id], 
            ['class' => 'btn btn-success']) 
        ?>
    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tarea</th>
                <th>Estado</th>
                <th>Asignado a</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->tasks as $task): ?>
                <tr>
                    <td><?= \yii\helpers\Html::encode($task->title) ?></td>
                    <td>
                        <span class="badge" style="background-color: gray;">
                            <?= $task->status ?>
                        </span>
                    </td>
                    <td>
                        <?= $task->assigned_to ? $task->assignedTo->email : 'Sin asignar' ?> 
                    </td>
                    <td>
                        <?php if($task->status !== 'done'): ?>
                            <?= \yii\helpers\Html::a('Marcar Done', 
                                ['task/update-status', 'id' => $task->id, 'status' => 'done'], 
                                ['class' => 'btn btn-xs btn-primary', 'data-method' => 'post']) 
                            ?>
                        <?php endif; ?>
                        
                        <?= \yii\helpers\Html::a('Ver', ['task/view', 'id' => $task->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (empty($model->tasks)): ?>
                <tr><td colspan="4">No hay tareas en este proyecto.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
