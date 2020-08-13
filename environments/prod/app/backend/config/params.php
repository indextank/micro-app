<?php
return [

    /* ------------------------------------------------------------------------------------*
     *                       日志记录                                                       *
     * ------------------------------------------------------------------------------------*/

    'user.log' => true,
    'user.log.level' => YII_DEBUG ? ['success', 'info', 'warning', 'error'] : ['warning', 'error'], // 级别 ['success', 'info', 'warning', 'error']
    'user.log.noPostData' => [ // 安全考虑,不接收Post存储到日志的路由
        //'v1/site/login',
    ],
    'user.log.except.code' => [], // 不记录的code
];
