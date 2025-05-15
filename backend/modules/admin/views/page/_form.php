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
<div class="page-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="c_b">
        <div class="col_left_5">
            <?= $form->field($model, 'headline')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'breadcrumps', [
                'template' => '<label class="control-label" for="product-title">{label}</label>{input}<div class="translit fa fa-code"></div>{error}',
                'options' => ['class' => 'form-group form_translit auto_form_inp'],
            ])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'menu_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url_page')->textInput(['maxlength' => true, 'class' => 'form-control translit-eng']) ?>

            <?= $form->field($model, 'shablon')->widget(Select2::classname(), [
                'data' => $model->getShowShablonPage(),
                'options' => ['placeholder' => ''],
                'hideSearch' => true,
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
        <div class="col_left_5">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_desc')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'meta_key')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'cannonical')->textInput() ?>

            <?= $form->field($model, 'active')->checkbox() ?>

            <?= $form->field($model, 'status')->checkbox() ?>

            <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
            <?= $form->field($model, 'image_order')->hiddenInput(['id' => 'image-order'])->label(false) ?>
            <?= $form->field($model, 'images_to_delete')->hiddenInput(['id' => 'images-to-delete'])->label(false) ?>
            <div class="existing-images">
                <?php if (!empty($images)): ?>
                    <h4 class="mb-3">Загруженные изображения:</h4>
                    <div id="sortable-images" class="row g-4"> <!-- Увеличены отступы между элементами -->
                        <?php foreach ($images as $image): ?>
                            <div class="col-auto position-relative image-container" data-id="<?= $image->id ?>" data-sort="<?= $image->sort ?>">
                                <div class="border p-3 rounded bg-light position-relative">
                                    <img src="<?= Yii::$app->params['frontUrl'] . '/data/page/' . $image->image_name ?>" class="img-fluid rounded" style="max-width: 120px; max-height: 120px;"> <!-- Увеличен размер изображения -->
                                    <button class="btn btn-danger btn-xs position-absolute top-0 end-0 delete-image-btn p-0" style="transform: translate(40%, -40%); font-size: 12px; width: 18px; height: 18px; line-height: 14px; text-align: center; border-radius: 50%;">×</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Нет загруженных изображений.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="../css/many-images-field.css">
    <script src="../js/many-images-field.js">
    </script>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder', []),]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>