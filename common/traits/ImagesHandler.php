<?php

namespace common\traits;

use common\models\Image;
use Yii;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\web\UploadedFile;

trait ImagesHandler
{
    public $image_order;
    public $images_to_delete;
    private $images;
    private $imageFile;
    private $class;
    private $uploadPath;
    public function init()
    {
        parent::init();
        // Добавляем валидационные правила динамически
        $this->validators->append(Validator::createValidator('safe', $this, ['image_order', 'images_to_delete']));
        $this->uploadPath = Yii::getAlias("@frontend/web/upload/");
        $this->class = strtolower(array_reverse(explode("\\", get_class($this)))[0]);
    }
    // Связь с изображениями
    public function getImages()
    {
        return $this->hasMany(Image::class, ['object_id' => 'id'])->where(['object_type' => $this->class]);
    }
    public function beforeSave($insert)
    {
        if (in_array('image', $this->fields())) {
            $this->imageFile = UploadedFile::getInstance($this, 'image');
            if ($this->imageFile) {
                $this->saveImage();
            }
            if (empty(trim($this->image, ""))) {
                $this->image = $this->getOldAttribute('image'); // Если новое изображение не установлено, сохраняем старое
            } elseif (!empty(trim($this->getOldAttribute('image'), ""))) {
                // Если загружается новое изображение, удаляем старое
                $oldImagePath = $this->uploadPath . $this->getOldAttribute('image');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
        $this->handleImages();
        return parent::beforeSave($insert);
    }

    /**
     * Set {$this} as param.
     * This method need to save, sort and delete images
     * @param object $this
     * @return void
     */
    public function handleImages()
    {

        $this->images = UploadedFile::getInstances($this, 'images');

        if ($this->imageFile) $this->saveImage();
        if ($this->images) $this->saveImages();
        if ($this->image_order) $this->sortImages();
        if ($this->images_to_delete) $this->deleteImages($this->images_to_delete);
    }
    private function saveImages()
    {
        $dir = $this->uploadPath . DIRECTORY_SEPARATOR;
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir);
        }
        foreach ($this->images as $image) {
            $image_name = uniqid($this->class . "_") . '.' . $image->extension;
            $imageModel = new Image();
            $imageModel->object_id = $this->id;
            $imageModel->object_type = $this->class;
            $imageModel->image_name = $image_name;
            $imageModel->save();
            $image->saveAs($dir . $image_name);
        }
    }
    private function sortImages()
    {
        $orderData = json_decode($this->image_order);
        foreach ($orderData as $item) {
            $image = Image::findOne($item->id);
            if ($image) {
                $image->sort = $item->sort;
                $image->save();
            }
        }
    }
    private function deleteImages($imagesToDelete)
    {
        if (empty($imagesToDelete)) {
            return;
        }
        $imagesToDelete = json_decode($imagesToDelete, 1);
        $gallery = $imagesToDelete['image_name'];
        if ($imagesToDelete['image_name']) {

            foreach ($gallery as $imageData) {
                $image = Image::findOne(['image_name' => $imageData]);
                if ($image) {
                    $filePath = $this->uploadPath . $image->image_name;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $image->delete();
                }
            }
            unset($imagesToDelete['image_name']);
        }
        foreach ($imagesToDelete as $key => $imageData) {
            foreach ($imageData as $image) {
                $filePath = $this->uploadPath . $image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $this->$key = null;
            }
        }
    }

    private function saveImage()
    {
        $imageFile = $this->imageFile;

        if (!$imageFile) return;

        $fileName = uniqid($this->class . "_") . '.' . $imageFile->extension;

        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        if ($imageFile->saveAs($this->uploadPath . $fileName)) {
            $this->image = $fileName;
        }
    }
}
