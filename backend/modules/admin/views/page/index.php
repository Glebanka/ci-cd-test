<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Менеджер страниц';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => '10']],
                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn', 'headerOptions' => ['width' => '80']],

                            'menu_name',
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
                                'filter' => ['Нет', 'Да'],
                                'headerOptions' => ['width' => '100'],
                                'format' => 'raw',
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>
