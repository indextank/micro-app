<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use common\helpers\CommonHelper;
use common\helpers\EncryptHelper;
use common\models\forms\SignAuthForm;
use yii\web\UnprocessableEntityHttpException;

/**
 * http 签名验证
 *
 * Class HttpSignAuth
 * @package api\behaviors
 */
class HttpSignAuth extends Behavior
{
    /**
     * 方法白名单
     *
     * @var array
     */
    public $optional = [];

    /**
     * @return array
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param $event
     * @return bool
     * @throws UnprocessableEntityHttpException
     */
    public function beforeAction($event)
    {
        if (in_array(Yii::$app->controller->action->id, $this->optional)) {
            return true;
        }

        $data = Yii::$app->request->get();
        $model = new SignAuthForm();
        $model->attributes = $data;
        if (!$model->validate()) {
            throw new UnprocessableEntityHttpException(CommonHelper::analyErr($model->getFirstErrors()));
        }

        return EncryptHelper::decodeUrlParam($data, $model->appSecret);
    }
}