<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/9
 * Time: 15:11
 */
require_once("./private/next_config.php");
$pid = $_POST['pid'];
$able = $_POST['able'];
$bldb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_BLDBNAME);
$bldb->query("set character set 'utf8'");
$bldb->query("set names 'utf8'");
if ($able == 'auto'){
    $data = 'not';
    $blupdate = "UPDATE `Blog`.`article` SET `status` = '0' WHERE `article`.`ID` = ".$article.";";
}
else{
    $data = 'auto';
    $blupdate = "UPDATE `Blog`.`article` SET `status` = '1' WHERE `article`.`ID` = ".$article.";";
}
$bldb->query($blupdate);
$bldb->close();
echo $data;