<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Test;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'Hello World! ~ Frontend';
    }

    public function actionList()
    {
        p('frontend前端输出内容：');
        $result = test::find()->where('id < 5')->asArray()->all();

        p($result);
    }
}