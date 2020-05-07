<?php

namespace common\models\member;

use Yii;
use yii\base\Model;

/**
 * 登录注册基类
 *
 * Class LoginForm
 * @package common\models\base
 */
abstract class LoginForm extends Model
{
    /**
     * 账号
     *
     * @var
     */
    public $username;

    /**
     * 密码
     *
     * @var
     */
    public $password;

    /**
     * 记住自己
     *
     * @var bool
     */
    public $rememberMe = true;

    protected $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return mixed
     */
    abstract public function getUser();

    /**
     * 验证账号密码
     *
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            /* @var $user \common\models\base\BaseUser */
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '账号或者密码错误');
            }
        }
    }

    /**
     * 登录
     *
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }
}