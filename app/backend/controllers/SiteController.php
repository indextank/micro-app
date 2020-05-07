<?php

namespace app\controllers;

use Yii;
use common\models\common\Provinces;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'Hello World! backend~~';
    }

    public function actionList()
    {
        $result = Provinces::find()->where('id < 5')->asArray()->all();

        p($result);
    }
}