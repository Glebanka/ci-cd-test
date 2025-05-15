<?php

namespace common\models;

use common\traits\ImagesHandler;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property string $title
 * @property string $meta_desc
 * @property string $meta_key
 * @property string $cannonical
 * @property string $headline
 * @property string $breadcrumps
 * @property string $menu_name
 * @property string $url_page
 * @property string $content
 * @property string $shablon
 * @property int $active
 * @property int $status
 * @property int $sort
 */
class Page extends \yii\db\ActiveRecord
{
    use ImagesHandler;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {        
        return [
            [['title', 'headline', 'breadcrumps', 'menu_name', 'url_page', 'shablon', 'active'], 'required'],
            [['meta_desc', 'meta_key', 'cannonical', 'content', 'shablon'], 'string'],
            [['active', 'status', 'sort'], 'integer'],
            [['title', 'headline', 'breadcrumps', 'menu_name', 'url_page'], 'string', 'max' => 255],
            [['url_page'], 'unique'],
            //[['image_order', 'images_to_delete'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'meta_desc' => 'Meta Description',
            'meta_key' => 'Meta KeyWords',
            'cannonical' => 'Canonical',
            'headline' => 'Заголовок H1',
            'breadcrumps' => 'Хлебные крошки',
            'menu_name' => 'Наименование меню',
            'url_page' => 'ЧПУ',
            'content' => 'Контент',
            'shablon' => 'Шаблон',
            'active' => 'Статус',
            'status' => 'Отображать в меню',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return array
     */
    public function getShowShablonPage()
    {
        $arr_all_page = scandir(Yii::getAlias('@frontend') . '/modules/main/views/page/');
        unset($arr_all_page[0]);
        unset($arr_all_page[1]);
        $arr_page = [];
        foreach ($arr_all_page as $page) {
            $now = explode(".php", $page);
            $arr_page[$now[0]] = $now[0];
        }
        return $arr_page;
    }

    /**
     * @return array
     */
    public function getActiveStatus()
    {
        return ['Скрыть', 'Отображать'];
    }

    /**
     * @return array
     */
    public function getActiveMenu()
    {
        return ['Нет', 'Да'];
    }
    // Связь с изображениями
    public function getImages()
    {
        return $this->hasMany(Image::class, ['object_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);        
        $this->handleImages($this);
    }
}
