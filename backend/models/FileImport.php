<?php
namespace backend\models;

use yii\base\Model;

class FileImport extends Model
{
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions'=>['csv'], 'checkExtensionByMimeType'=>false, 'maxSize'=>1024 * 1024 * 2]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Файл для импорта CSV',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if (file_exists('files/import/')) {
                foreach (glob('files/import/*') as $file) {
                    unlink($file);
                }
            }
            $this->file->saveAs('files/import/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}