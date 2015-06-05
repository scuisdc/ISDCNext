<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/2
 * Time: 17:28
 */
define("ISDCBK_MYSQL_HOST", "127.0.0.1");
define("ISDCBK_MYSQL_USER", "traindbusr");
define("ISDCBK_MYSQL_PWD", "QMy2cwUWUh");
define("ISDCBK_MYSQL_UCDBNAME", "UserCenter");
define("ISDCBK_MYSQL_TPDBNAME", "TrainPlatform");
define("ISDCBK_MYSQL_PSDBNAME", "PublicService");
define("ISDCBK_MYSQL_BLDBNAME", "Blog");
define("ISDCBK_MYSQL_CMSDBNAME", "CMS");

define("ISDCBK_MYSQL_USRTBNAME", "user");

$PRIVILEGE = [
    0 => false, //用户
    1 => false, //超级管理员     管理成员
    2 => false, //CMS           首页 关于我们
    3 => false, //博客
    4 => false, //oj
    5 => false, //ctf
    6 => false, //任务中心
    7 => false, //公共服务
];

