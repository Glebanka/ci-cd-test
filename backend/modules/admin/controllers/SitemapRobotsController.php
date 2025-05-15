<?php

namespace app\modules\admin\controllers;

use backend\models\SitemapRobotsForm;
use common\controllers\AuthController;
use Yii;
use yii\helpers\Html;

/**
 * SitemapRobotsController implements the CRUD actions for Service model.
 */
class SitemapRobotsController extends AuthController
{
    public function actionIndex()
    {
        $sitemapPath = Yii::getAlias('@frontend/web/sitemap.xml');
        $robotsPath = Yii::getAlias('@frontend/web/robots.txt');
        $model = new SitemapRobotsForm();
        if ($model->load(Yii::$app->request->post())) {
            file_put_contents($sitemapPath, $model->sitemapContent);
            file_put_contents($robotsPath, $model->robotsContent);
            return $this->redirect(['/sitemap-robots']);
        }
        return $this->render('create', ['model' => $model]);
    }
}
