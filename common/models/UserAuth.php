<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_auth}}".
 *
 * @property int $user_id
 * @property string $fio
 * @property string $tel
 * @property int $mailer
 * @property int $delivery_org_id
 * @property int $delivery_id
 * @property int $city
 * @property string $code_activation
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_auth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'mailer', 'delivery_org_id', 'delivery_id'], 'integer'],
            [['fio', 'code_activation', 'city'], 'string'],
            [['tel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'fio' => 'Fio',
            'tel' => 'Tel',
            'mailer' => 'Mailer',
            'code_activation' => 'code_activation',
        ];
    }
}
