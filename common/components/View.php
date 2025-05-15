<?php

namespace common\components;

use common\models\Image;
use Yii;
use yii\web\View as WebView;

class View extends WebView
{

    public function render($view, $params = [], $context = null)
    {
        // Автоматически передаём $model в params
        if (isset($params['model'])) {
            $this->params['model'] = $params['model'];
        }

        return parent::render($view, $params, $context);
    }
    public function init()
    {
        parent::init();
    }
    private function getMinimalClassName($objectClass)
    {
        return strtolower(array_reverse(explode("\\", get_class($objectClass)))[0]);
    }
    /**
     * @return array
     */
    public function getStatusLabelsForFilter()
    {
        return ['Скрыть', 'Отображать'];
    }
    /**
     * @return string
     */
    public function getStatusLabel(int $status)
    {
        $labels = [
            '<span class="alert alert-danger m-0 p-1 text-center">Скрыть</span>',
            '<span class="alert alert-success m-0 p-1 text-center">Отображать</span>'
        ];
        return $labels[$status];
    }
    public function getSortField()
    {
        return [
            'attribute' => 'sort',
            'headerOptions' => ['width' => '10'],
            'format' => 'raw',
        ];
    }
    public function getImageHTML($image, bool $isEdit = true, string $fieldName = "image"): string
    {
        $imageName = trim($image, "");
        if (empty($imageName)) {
            return "<div class='no-image'>Изображение отсутствует</div>";
        }
        $editButton = $isEdit ? "<button type='button' class='btn btn-danger btn-xs delete-image-btn' data-name='$imageName' data-field='$fieldName'>×</button>" : '';
        return "<div class='single-image' data-name='$imageName' data-field='$fieldName' style=\"background-image: url(/upload/$imageName);\">$editButton</div>";
    }

    public function getGalleryHTML($images, bool $isEdit = true)
    {
        $html = '<div class="existing-images">';
        if (!empty($images)) {
            $html .= '<h4 class="mb-3">Загруженные изображения:</h4>
            <div id="sortable-images" class="row g-4">';
            foreach ($images as $image) {
                $imageHtml = $this->getImageHTML($image->image_name, $isEdit, 'image_name');
                $html .= "<div class='position-relative image-container' data-id='$image->id' data-sort='$image->sort'>$imageHtml</div>";
            }
            $html .= '</div>';
        } else {
            $html .= '<p class="text-muted">Нет загруженных изображений.</p>';
        }
        $html .= '</div>';
        return $html;
    }

    public function getShowField($attr)
    {
        return [
            'attribute' => $attr,
            'value' => function ($data) use ($attr) {
                return $this->getStatusLabel($data->$attr);
            },
            'filter' => $this->getStatusLabelsForFilter(),
            'headerOptions' => ['width' => '100'],
            'format' => 'raw',
        ];
    }
    public function getImagesField($objectClass)
    {
        $className = $this->getMinimalClassName($objectClass);
        return [
            'attribute' => 'images',
            'value' => function ($data) use ($className) {
                $images = Image::find()->where(['object_type' => $className, 'object_id' => $data->id])
                    ->orderBy(['sort' => SORT_ASC, 'id' => SORT_DESC])->all();

                return $this->getGalleryHTML($images, false);
            },
            'format' => 'raw',
        ];
    }

    public function getImageField($model = null)
    {
        if (isset($model)) {
            $value = $this->getImageHTML($model->image, false);
        } else {
            $value = function ($data) {
                return $this->getImageHTML($data->image, false);
            };
        }
        return [
            'attribute' => 'image',
            'value' => $value,
            'format' => 'raw',
        ];
    }
    public function getImageUrl($imageName)
    {
        return "/upload/$imageName";
    }
}
