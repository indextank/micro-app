<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600 * 24 * 7,

    // 开发模式 - 开启后某些菜单功能可见，修改后请刷新页面
    'sys_dev' => "dev",

    // 请求全局唯一ID
    'uuid' => '',

    // 验证码过期时间，单位秒
    'sms_expire_time' => 900,

    /* ------------------------------------------------------------------------------------*
     *                       mail 配置                                                     *
     * ------------------------------------------------------------------------------------*/

    // SMTP服务器   例如:smtp.163.com
    'smtp_host' => '',

    // 发件人名称   例如:徽哥
    'smtp_name' => "徽哥",

    // SMTP帐号    例如:mobile@163.com
    'smtp_username' => '',

    // SMTP客户端授权码   如果是163邮箱，此处要填授权码
    'smtp_password' => '',

    // SMTP端口   25、109、110、143、465、995、993
    'smtp_port' => '',

    // 使用SSL加密  开启此项后，连接将用SSL的形式，此项需要SMTP服务器支持 0:关闭; 1:开启;
    'smtp_encryption' => 0,
];
