<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/9
 * Time: 15:11
 */
require_once("./private/next_config.php");
$comment = $_POST['comment'];
$able = $_POST['able'];
$bldb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_BLDBNAME);
$bldb->query("set character set 'utf8'");
$bldb->query("set names 'utf8'");

if ($able == 'enable'){
    $data = 'disable';
    $blupdate = "UPDATE `Blog`.`comments` SET `status` = '0' WHERE `comments`.`ID` = ".$comment.";";
}
else{
    $data = 'enable';
    $blupdate = "UPDATE `Blog`.`comments` SET `status` = '1' WHERE `comments`.`ID` = ".$comment.";";
}
$bldb->query($blupdate);
$bldb->close();
echo $data;