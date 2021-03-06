<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./App/');

//根目录路径
define('ROOT_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

//文件上传目录
define('UPLOAD_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR);

//引入环境变量配置,请重名env.conf.php.example文件为env.conf.php，并修改配置
require ROOT_PATH.'env.conf.php';

// 引入ThinkPHP入口文件
require './Core/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单