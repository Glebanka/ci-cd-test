<?php
namespace common\models;

use yii\db\ActiveRecord;

class Image extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%images}}';
    }

    public function rules()
    {
        return [
            [['object_id', 'image_name'], 'required'],
            [['object_id'], 'integer'],
            [['image_name'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
            'image_url' => 'Image URL',
            'created_at' => 'Created At',
        ];
    }
    // Связь со страницей
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'object_id']);
    }
}