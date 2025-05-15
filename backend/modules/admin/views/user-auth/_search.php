<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\UserAuthSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-auth-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'delivery_org_id') ?>

    <?= $form->field($model, 'fio') ?>

    <?= $form->field($model, 'tel') ?>

    <?= $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'mailer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
