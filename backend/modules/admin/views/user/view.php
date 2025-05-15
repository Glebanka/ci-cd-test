<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Пользователь: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Все пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="user-view">

            <p>
                <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    // 'avatar',
                    [
                        'label' => 'Логин',
                        'value' => function($data){
                            return $data->username;
                        },
                    ],
                    'email:email',
                    'status',
                    [
                        'label' => 'Регистрация',
                        'value' => function($data){
                            return strftime('%d.%m.%Y %H:%M:%S', $data->created_at);
                        },
                    ],
                    [
                        'label' => 'Редактирование',
                        'value' => function($data){
                            return strftime('%d.%m.%Y %H:%M:%S', $data->updated_at);
                        },
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>
