<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/6
 * Time: 00:31
 */
require_once("./private/next_config.php");
session_start();
header('charset=utf-8');
if (isset($_SESSION['valid_user'])) {
    $username = $_SESSION['valid_user'];
}
else {
    header("Location: http://www.scuisdc.com");
}
$privilege = [
    0 => 0, //用户
    1 => 0, //超级管理员
    2 => 0, //CMS
    3 => 0, //博客
    4 => 0, //oj
    5 => 0, //ctf
    6 => 0, //任务中心
    7 => 0, //公告服务
];
$ucdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_UCDBNAME);
$ucdb->query("set character set 'utf8'");
$ucdb->query("set names 'utf8'");
$ucsearch = "SELECT `privilege` FROM " . ISDCBK_MYSQL_USRTBNAME . " WHERE `username`='".$username."'";
$result = $ucdb->query($ucsearch);
if (!$result){
    header("Location: http://www.scuisdc.com/hhh");
    exit();
}
$row = $result->fetch_array(MYSQLI_ASSOC);
$numpri = $row["privilege"];
$result->close();
while($numpri){
    $privilege[$i] = $numpri % 2;
    $numpri /= 2;
    $i += 1;
}
$modprivilege = $_POST['privilege'];
$modusr = $_POST['usr'];

if (!$privilege[0]){
    header("Location: http://www.scuisdc.com/hhh");
    exit();
}
if (!$privilege[1]){
    header("Location: http://www.scuisdc.com/hhh");
    exit();
}

$ucupdate = "UPDATE `UserCenter`.`user` SET `privilege` = '".$modprivilege."' WHERE `user`.`ID` = ".$modusr.";";
$ucdb->query($ucupdate);

$ucdb->close();

