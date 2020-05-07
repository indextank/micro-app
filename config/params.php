<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    // 开发模式 - 开启后某些菜单功能可见，修改后请刷新页面
    'sys_dev' => env('ENVIRONMENT'),

    // 请求全局唯一ID
    'uuid' => '',

    'sms_expire_time' => env('SMS_EXPIRE_TIME'),

    /* ------------------------------------------------------------------------------------*
     *                       mail 配置                                                     *
     * ------------------------------------------------------------------------------------*/

    // SMTP服务器   例如:smtp.163.com
    'smtp_host' => env('SMTP_HOST'),

    // 发件人名称   例如:徽哥
    'smtp_name' => env('SMTP_NAME'),

    // SMTP帐号    例如:mobile@163.com
    'smtp_username' => env('SMTP_USERNAME'),

    // SMTP客户端授权码   如果是163邮箱，此处要填授权码
    'smtp_password' => env('SMTP_PASSWORD'),

    // SMTP端口   25、109、110、143、465、995、993
    'smtp_port' => env('SMTP_PORT'),

    // 使用SSL加密  开启此项后，连接将用SSL的形式，此项需要SMTP服务器支持 0:关闭; 1:开启;
    'smtp_encryption' => env('SMTP_ENCRYPTION'),
];
