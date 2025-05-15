<?php

namespace backend\models;

use yii\base\Model;
use common\models\User;
use Yii;
use yii\helpers\Html;

/**
 * Signup form
 */
class SitemapRobotsForm extends Model
{
    public $sitemapContent;
    public $robotsContent;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sitemapContent', 'robotsContent'], 'required'],
            [['sitemapContent', 'robotsContent'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'sitemapContent' => 'sitemap.xml',
            'robotsContent' => 'robots.txt',
        ];
    }
    public function init()
    {
        $sitemapPath = Yii::getAlias('@frontend/web/sitemap.xml');
        if (file_exists($sitemapPath)) {
            $this->sitemapContent = file_get_contents($sitemapPath);
        }
        $robotsPath = Yii::getAlias('@frontend/web/robots.txt');
        if (file_exists($robotsPath)) {
            $this->robotsContent = file_get_contents($robotsPath);
        }
    }
}
