<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/9
 * Time: 15:11
 */
require_once("./private/next_config.php");
$comment = $_POST['comment'];
$bldb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_BLDBNAME);
$bldb->query("set character set 'utf8'");
$bldb->query("set names 'utf8'");

$bldelete = "DELETE FROM `Blog`.`comments` WHERE `comments`.`ID` = ".$comment.";";
$bldb->query($bldelete);
echo $bldelete;
$bldb->close();