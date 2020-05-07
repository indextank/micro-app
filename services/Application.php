<?php

namespace services;

use common\components\Service;

/**
 * Class Application
 *
 * @package services
 * @property \services\api\AccessTokenService $apiAccessToken Api授权key
 * @property \services\member\MemberService $member 会员
 * @property \services\common\ReportLogService $reportLog 风控日志
 * @property \services\member\MemberAuthService $merchantMemberAuth 会员第三方授权
 * @property \services\common\ActionLogService $actionLog 行为日志
 * @property \services\common\ActionBehaviorService $actionBehavior 可被记录的行为
 * @property \services\common\LogService $log 公用日志
 * @property \services\common\MailerService $mailer 公用邮件
 * @property \services\common\SmsService $sms 公用短信
 * @property \services\common\ProvincesService $provinces ip黑名单
 * @property \services\common\IpBlacklistService $ipBlacklist 省市区
 *
 */
class Application extends Service
{
    /**
     * @var array
     */
    public $childService = [
        'apiAccessToken' => [
            'class' => 'services\api\AccessTokenService',
            'cache' => false, // 启用缓存到缓存读取用户信息
            'timeout' => 720, // 缓存过期时间，单位秒
        ],

        /** ------ 用户 ------ **/
        'member' => 'services\member\MemberService',
        'memberAuth' => 'services\member\MemberAuthService',

        /** ------ 公用部分 ------ **/
        'actionLog' => 'services\common\ActionLogService',
        'actionBehavior' => 'services\common\ActionBehaviorService',
        'reportLog' => 'services\common\ReportLogService',
        'ipBlacklist' => 'services\common\IpBlacklistService',
        'provinces' => 'services\common\ProvincesService',

        'log' => [
            'class' => 'services\common\LogService',
            'queueSwitch' => false, // 是否丢进队列
            'exceptCode' => [403] // 除了数组内的状态码不记录，其他按照配置记录
        ],
        'sms' => [
            'class' => 'services\common\SmsService',
            'queueSwitch' => false, // 是否丢进队列
        ],
        'mailer' => [
            'class' => 'services\common\MailerService',
            'queueSwitch' => false, // 是否丢进队列
        ],
    ];
}