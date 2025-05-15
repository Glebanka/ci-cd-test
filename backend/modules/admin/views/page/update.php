<?php

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = 'Редактирование: ' . $model->menu_name;
$this->params['breadcrumbs'][] = ['label' => 'Менеджер страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'images' => $images,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
