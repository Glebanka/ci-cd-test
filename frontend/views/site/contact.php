<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\bootstrap5\ActiveForm;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
            ]); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'imageFiles[]', [
                'template' => '{label}{input}<div id="previewContainer" class="preview-container"></div>{error}{hint}',
            ])->fileInput([
                'multiple' => true,
                'accept' => 'image/*',
                'id' => 'imageInput'
            ]) ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Массив для накопления всех выбранных файлов
                    const allFiles = [];
                    // Получаем элементы input и контейнер превью
                    const imageInput = document.getElementById('imageInput');
                    const previewContainer = document.getElementById('previewContainer');

                    /**
                     * Слушатель события валидации для поля загрузки файлов.
                     * После валидации (если ошибок нет) добавляем новые файлы и обновляем превью.
                     */
                    $('#contact-form').on('afterValidateAttribute', function(event, attribute, messages) {
                        // Обрабатываем только атрибут загрузки файлов;
                        // убедитесь, что имя совпадает с тем, что генерирует Yii (пример: 'imageFiles[]' или 'YourModel[imageFiles][]')
                        if (attribute.name !== 'imageFiles[]') return;

                        // Если обнаружены ошибки валидации — обновляем input и выходим
                        if (messages.length > 0) {
                            updateInputFileList();
                            return;
                        }

                        // Собираем файлы, выбранные пользователем
                        const newFiles = Array.from(imageInput.files);

                        // Если файлы не изменились, ничего не делаем (функция сравнения ниже)
                        if (areFileArraysEqual(newFiles, allFiles)) {
                            return;
                        }

                        // Проверяем, что общее количество файлов не превышает лимит (например, 5 файлов)
                        if (newFiles.length + allFiles.length > 5) {
                            updateInputFileList();
                            // Обновляем ошибку для данного поля через метод updateAttribute.
                            // Обратите внимание: имя поля в updateAttribute должно соответствовать тому, что используется в форме.
                            $('#contact-form').yiiActiveForm('updateAttribute', 'imageInput', ["Вы не можете загружать более 5 файлов."]);
                            return;
                        }

                        // Добавляем новые файлы, если их ещё нет в нашем массиве (проверяем по name и size)
                        newFiles.forEach(file => {
                            const exists = allFiles.some(f => f.name === file.name && f.size === file.size);
                            if (!exists) {
                                allFiles.push(file);
                            }
                        });

                        // Обновляем превью и синхронизируем input
                        updatePreview();
                        updateInputFileList();
                    });

                    /**
                     * Функция синхронизации FileList input'а с глобальным массивом allFiles.
                     * Создаём новый объект DataTransfer и добавляем в него файлы из allFiles.
                     */
                    function updateInputFileList() {
                        const dataTransfer = new DataTransfer();
                        allFiles.forEach(file => dataTransfer.items.add(file));
                        imageInput.files = dataTransfer.files;
                    }

                    /**
                     * Функция обновления превью.
                     * Добавляет новые превью-элементы для файлов, которых ещё нет, и удаляет превью для файлов,
                     * удалённых из allFiles.
                     */
                    function updatePreview() {
                        // Добавляем превью для новых файлов
                        allFiles.forEach(file => {
                            const key = generateFileKey(file);
                            if (!previewContainer.querySelector('[data-file-key="' + key + '"]')) {
                                createPreview(file);
                            }
                        });

                        // Удаляем превью для файлов, которых уже нет в allFiles
                        const previewItems = previewContainer.querySelectorAll('.preview-item');
                        previewItems.forEach(item => {
                            const key = item.getAttribute('data-file-key');
                            const exists = allFiles.some(file => generateFileKey(file) === key);
                            if (!exists) {
                                item.remove();
                            }
                        });
                    }

                    /**
                     * Функция создания уникального ключа файла (на основе имени и размера).
                     * @param {File} file
                     * @returns {string} Уникальный ключ
                     */
                    function generateFileKey(file) {
                        return file.name + '_' + file.size;
                    }

                    /**
                     * Создает новый элемент превью для файла.
                     * @param {File} file 
                     */
                    function createPreview(file) {
                        const key = generateFileKey(file);
                        // Создаем контейнер превью с нужными классами и data-атрибутом
                        const previewDiv = document.createElement('div');
                        previewDiv.classList.add('preview-item');
                        previewDiv.setAttribute('data-file-key', key);

                        // Создаем кнопку удаления и навешиваем обработчик
                        const removeBtn = document.createElement('button');
                        removeBtn.classList.add('preview-remove-btn');
                        removeBtn.textContent = 'X';
                        removeBtn.addEventListener('click', () => removeFile(key));

                        // Асинхронно читаем файл для получения DataURL и затем формируем элемент превью
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            previewDiv.appendChild(img);
                            previewDiv.appendChild(removeBtn);
                            previewContainer.appendChild(previewDiv);
                        };
                        reader.readAsDataURL(file);
                    }

                    /**
                     * Удаляет файл из allFiles по уникальному ключу и обновляет превью и input.
                     * Также запускает повторную валидацию поля.
                     * @param {string} key Уникальный ключ файла
                     */
                    function removeFile(key) {
                        const index = allFiles.findIndex(file => generateFileKey(file) === key);
                        if (index > -1) {
                            allFiles.splice(index, 1);
                        }
                        updatePreview();
                        updateInputFileList();
                        $('#imageInput').closest('form').yiiActiveForm('validateAttribute', 'imageInput', true);
                    }

                    /**
                     * Сравнивает два массива файлов по содержимому (по атрибутам name и size).
                     * @param {File[]} arr1
                     * @param {File[]} arr2
                     * @returns {boolean} true, если массивы совпадают, иначе false
                     */
                    function areFileArraysEqual(arr1, arr2) {
                        if (arr1.length !== arr2.length) return false;
                        return arr1.every(file1 =>
                            arr2.some(file2 => file1.name === file2.name && file1.size === file2.size)
                        );
                    }
                });
            </script>

            <style>
                .preview-container {
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                    margin-top: 10px;
                }

                .preview-item {
                    width: 120px;
                    text-align: center;
                    position: relative;
                }

                .preview-item img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    border-radius: 4px;
                }

                .preview-remove-btn {
                    position: absolute;
                    top: 0;
                    right: 0;
                    background: red;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    cursor: pointer;
                    padding: 5px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-size: 8px;
                }
            </style>



            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>