<?php

namespace api\modules\v1\controllers;

use yii\web\NotFoundHttpException;
use api\controllers\OnAuthController;
use common\models\member\Member;

/**
 * 会员接口
 *
 * Class MemberController
 * @package api\modules\v1\controllers\member
 * @property \yii\db\ActiveRecord $modelClass
 */
class MemberController extends OnAuthController
{
    /**
     * @var Member
     */
    public $modelClass = Member::class;

    /**
     * 获取某个用户的基本信息
     *
     * Method: Get
     * Oauth2.0: 填写/v1/site/login接口获取的access_token
     * Url: http://****.com/v1/member/view?id=2
     *
     *  参数名	    参数类型	    必填	默认	说明	备注
     *  id	         int	    是	    无	    用户ID
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->modelClass::find()
            ->where(['id' => $id, 'status' => 1])
            ->select([
                'id', 'username', 'nickname',
                'realname', 'head_portrait', 'gender',
                'qq', 'email', 'birthday', 'status',
                'created_at'
            ])
            ->asArray()
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('请求的数据不存在或您的权限不足.');
        }

        return $model;
    }

    /**
     * 权限验证
     *
     * @param string $action 当前的方法
     * @param null $model 当前的模型类
     * @param array $params $_GET变量
     * @throws \yii\web\BadRequestHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // 方法名称
        if (in_array($action, ['delete', 'index'])) {
            throw new \yii\web\BadRequestHttpException('权限不足');
        }
    }
}
