<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$id_user = Yii::$app->user->id;
if(/* $id_user === 1 */ true){
    $template = '{view} {update} {delete}';
    $width = '80';
} else {
    $template = '';
    $width = '10';
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?php /* if($id_user === 1){ */ ?>
                                <!-- Html::a('Добавить пользователя', ['/site/signup'], ['class' => 'btn btn-success']) -->
                                <?= Html::a('Добавить пользователя', ['/admin/user/create'], ['class' => 'btn btn-success'])?>

                            <?php /* } */ ?>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => '10']],
                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn', 'template' => $template, 'headerOptions' => ['width' => $width]],
                            'username',
                            'email:email',
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
