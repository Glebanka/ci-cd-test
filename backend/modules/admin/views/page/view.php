<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Менеджер страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Уверены что хотите удалить?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'meta_desc:raw',
                            'meta_key:raw',
                            'cannonical:raw',
                            'headline',
                            'breadcrumps',
                            'menu_name',
                            'url_page:url',
                            'content:raw',
                            'shablon',
                            [
                                'attribute' => 'active',
                                'value' => function($data){
                                    if($data->active == '0'){
                                        $active = '<span class="alert alert-danger m-0 p-1 text-center">Скрыть</span>';
                                    } else {
                                        $active = '<span class="alert alert-success m-0 p-1 text-center">Отображать</span>';
                                    }
                                    return $active;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function($data){
                                    if($data->status == '0'){
                                        $active = '<span class="alert alert-danger m-0 p-1 text-center">Скрыть</span>';
                                    } else {
                                        $active = '<span class="alert alert-success m-0 p-1 text-center">Отображать</span>';
                                    }
                                    return $active;
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>