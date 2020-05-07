<?php

namespace api\modules\v1\controllers\member;

use api\controllers\UserAuthController;
use common\models\member\Auth;

/**
 * Class AuthController
 * @package api\modules\v1\controllers\member
 */
class AuthController extends UserAuthController
{
    /**
     * @var Auth
     */
    public $modelClass = Auth::class;
}