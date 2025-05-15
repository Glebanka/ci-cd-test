<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserAuthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Auths';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-auth-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Auth', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'delivery_org_id',
            'fio:ntext',
            'tel',
            'city',
            //'mailer',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
