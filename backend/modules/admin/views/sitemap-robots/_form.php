<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<div class="service-form">
    <?php $form = ActiveForm::begin(); ?>


    <div class="c_b row">
        <p>Если файлов нет, они создадутся</p>
        <div class="col-12">
            <?= $form->field($model, 'sitemapContent')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                'allowedContent' => true,
                'startupMode' => 'source',
                'toolbar' => []
            ])]) ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'robotsContent')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                'allowedContent' => true,
                'startupMode' => 'source',
                'toolbar' => []
            ])]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>