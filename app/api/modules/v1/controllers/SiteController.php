<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use common\helpers\ArrayHelper;
use common\models\member\Member;
use common\helpers\ResultHelper;
use api\modules\v1\forms\PasswordResetForm;
use api\controllers\OnAuthController;
use api\modules\v1\forms\LoginForm;
use api\modules\v1\forms\RefreshForm;
use api\modules\v1\forms\MobileLogin;
use api\modules\v1\forms\SmsCodeForm;
use api\modules\v1\forms\RegisterForm;
use yii\web\UnprocessableEntityHttpException;

/**
 * 登录接口
 *
 * Class SiteController
 * @package api\modules\v1\controllers
 */
class SiteController extends OnAuthController
{
    public $modelClass = '';

    /**
     * 不用进行登录验证的方法
     *
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected $authOptional = ['login', 'refresh', 'mobile-login', 'sms-code', 'register', 'up-pwd'];

    public function actionTest()
    {
        return 'hello world!';
    }

    /**
     * 登录根据用户信息返回accessToken
     *
     * 需要传入的参数: {"username":"admin","password":"123456","group":"wechat"}
     *
     *  参数名        参数类型        必填    默认    说明    备注
     *  username    string        是        无        账号
     *  password    string        是        无        密码
     *  group        string        是        无        组别    app:app,wechat:微信,miniProgram:小程序
     *
     * @return array|bool
     * @throws Exception
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->attributes = Yii::$app->request->post();

        if ($model->validate()) {
            return Yii::$app->services->apiAccessToken->getAccessToken($model->getUser(), $model->group);
        }

        // 返回数据验证失败
        return ResultHelper::json(422, $this->getError($model));
    }

    /**
     * 登出
     *
     * @return array|mixed
     */
    public function actionLogout()
    {
        dd(Yii::$app->user->identity->access_token);
        if (Yii::$app->services->apiAccessToken->disableByAccessToken(Yii::$app->user->identity->access_token)) {
            return ResultHelper::json(200, '退出成功');
        }

        return ResultHelper::json(200, '退出失败');
    }

    /**
     * 重置令牌
     *
     * 需要传入的参数: {"refresh_token":"3czGcgT4A7Wz0tWR1WzlxIs_JFTOFuhk_1571217307","group":"wechat"}
     *
     *  参数名            参数类型        必填    默认    说明        备注
     *  refresh_token    string        是        无        重置令牌
     *  group            string        是        无        组别        app:app,wechat:微信,miniProgram:小程序
     *
     * @return array
     * @throws Exception
     */
    public function actionRefresh()
    {
        $model = new RefreshForm();
        $model->attributes = Yii::$app->request->post();

        if (!$model->validate()) {
            return ResultHelper::json(422, $this->getError($model));
        }

        return Yii::$app->services->apiAccessToken->getAccessToken($model->getUser(), $model->group);
    }

    /**
     * 手机验证码登录Demo
     *
     * @return array|mixed
     * @throws Exception
     */
    private function actionMobileLogin()
    {
        $model = new MobileLogin();
        $model->attributes = Yii::$app->request->post();

        if ($model->validate()) {
            return Yii::$app->services->apiAccessToken->getAccessToken($model->getUser(), $model->group);
        }

        // 返回数据验证失败
        return ResultHelper::json(422, $this->getError($model));
    }

    /**
     * 获取验证码
     * Method:POST
     * url:/v1/site/sms-code
     *
     * 需要传入的参数:  {"mobile":"13001234567","usage":"register"}
     *
     *  参数名                    参数类型        必填    默认    说明        备注
     *  mobile                    string        是        无        手机号
     *  usage                     string        是        无        用途        login, register, up-pwd
     *
     * @return int|mixed
     * @throws UnprocessableEntityHttpException
     */
    public function actionSmsCode()
    {
        $model = new SmsCodeForm();
        $model->attributes = Yii::$app->request->post();
        if (!$model->validate()) {
            return ResultHelper::json(422, $this->getError($model));
        }

        return $model->send();
    }

    /**
     * 注册
     *
     *  ps: 注册时，需要先获取验证码code； hg_member表中所有字段原则上都可以带入，根据需要传入即可
     *
     *  需要传入的参数:  {"username":"test","mobile":"13001234567","code":"3484","realname":"王迩","password":"123456","password_repetition":"123456","group":"app"}
     *
     *  参数名	                参数类型	    必填	默认	说明	    备注
     *  username	            string	    否	    无	    用户名
     *  mobile	                string	    否	    无	    手机号
     *  code	                string	    否	    无	    验证码
     *  realname	            string	    否	    无	    真实姓名
     *  password	            string	    否	    无	    密码
     *  password_repetition	    string	    否	    无	    确认密码
     *  group	                string	    是	    无	    组别	    app:app,wechat:微信,miniProgram:小程序
     *
     * @return array|mixed
     * @throws Exception
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        $model->attributes = Yii::$app->request->post();
        if (!$model->validate()) {
            return ResultHelper::json(422, $this->getError($model));
        }

        $member = new Member();
        $member->attributes = ArrayHelper::toArray($model);
        $member->password_hash = Yii::$app->security->generatePasswordHash($model->password);

        if (!$member->save()) {
            return ResultHelper::json(422, $this->getError($member));
        }

        return Yii::$app->services->apiAccessToken->getAccessToken($member, $model->group);
    }

    /**
     * 密码重置
     *
     *  Method: POST
     *  Url: /v1/site/up-pwd
     *  ps: 密码重置时，需要先获取验证码code
     *
     *  需要传入的参数:  {"mobile":"13001234567","code":"4159","password":"123456","password_repetition":"123456","group":"app"}
     *
     *  参数名	                参数类型	    必填	默认	说明	    备注
     *  mobile	                string	    否	    无	    手机号
     *  code	                string	    否	    无	    验证码
     *  password	            string	    否	    无	    密码
     *  password_repetition	    string	    否	    无	    确认密码
     *  group	                string	    是	    无	    组别	    app:app,wechat:微信,miniProgram:小程序
     *
     * @return array|mixed
     * @throws Exception
     */
    public function actionUpPwd()
    {
        $model = new PasswordResetForm();
        $model->attributes = Yii::$app->request->post();

        if (!$model->validate()) {
            return ResultHelper::json(422, $this->getError($model));
        }

        $member = $model->getUser();
        $member->password_hash = Yii::$app->security->generatePasswordHash($model->password);

        if (!$member->save()) {
            return ResultHelper::json(422, $this->getError($member));
        }

        return Yii::$app->services->apiAccessToken->getAccessToken($member, $model->group);
    }

    /**
     * 权限验证
     *
     * @param string $action 当前的方法
     * @param null $model 当前的模型类
     * @param array $params $_GET变量
     * @throws BadRequestHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // 方法名称
        if (in_array($action, ['index', 'view', 'update', 'create', 'delete'])) {
            throw new \yii\web\BadRequestHttpException('权限不足');
        }
    }
}
