<?php

namespace api\modules\v1\forms;

use common\enums\AccessTokenGroupEnum;
use common\models\api\AccessToken;
use common\models\member\Member;

/**
 * Class LoginForm
 * @package api\modules\v1\forms
 *
 */
class LoginForm extends \common\models\member\LoginForm
{
    public $group;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'group'], 'required'],
            ['password', 'validatePassword'],
            ['group', 'in', 'range' => AccessTokenGroupEnum::getKeys()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '登录帐号',
            'password' => '登录密码',
            'group' => '组别',
        ];
    }

    /**
     * 用户登录
     *
     * @return mixed|null|static
     */
    public function getUser()
    {

        if ($this->_user == false) {
            // email 登录
            if (strpos($this->username, "@")) {
                $this->_user = Member::findOne(['email' => $this->username, 'status' => 1]);
            } else {
                $this->_user = Member::findByUsername($this->username);
            }
        }

        return $this->_user;
    }
}
