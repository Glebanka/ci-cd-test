<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $id
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['value', 'safe'],
            [['id', 'param', 'value', 'default', 'label', 'type'], 'safe', 'on' => 'search']
        ];
    }

    public function attributeLabels()
    {
        return [
            'param' => 'Константа',
            'value' => 'Значение',
            'default' => 'Значение по умолчанию',
            'label' => 'Описание',
            'type' => 'Тип input',
        ];
    }
}
