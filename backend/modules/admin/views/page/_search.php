<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'meta_desc') ?>

    <?= $form->field($model, 'meta_key') ?>

    <?= $form->field($model, 'cannonical') ?>

    <?php // echo $form->field($model, 'headline') ?>

    <?php // echo $form->field($model, 'breadcrumps') ?>

    <?php // echo $form->field($model, 'menu_name') ?>

    <?php // echo $form->field($model, 'url_page') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'shablon') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
