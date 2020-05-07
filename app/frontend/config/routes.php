<?php

return [
    'class' => 'yii\web\UrlManager',

    // 美化Url,默认不启用。但实际使用中，特别是产品环境，一般都会启用。
    'enablePrettyUrl' => true,

    // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
    // 否则认为是无效路由。
    // 这个选项仅在 enablePrettyUrl 启用后才有效。启用容易出错
    // 注意:如果不需要严格解析路由请直接删除或注释此行代码
    // 'enableStrictParsing' => true,

    // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
    'showScriptName' => false,

    // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
    'suffix' => '',

    'rules' => [

    ]
];