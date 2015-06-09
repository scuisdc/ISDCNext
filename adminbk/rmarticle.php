<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/9
 * Time: 15:11
 */
require_once("./private/next_config.php");
$article = $_POST['article'];
$bldb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_BLDBNAME);
$bldb->query("set character set 'utf8'");
$bldb->query("set names 'utf8'");
$blcomdelete = "DELETE FROM `Blog`.`comments` WHERE `comments`.`article_ID` = ".$article.";";
$bldelete = "DELETE FROM `Blog`.`article` WHERE `article`.`ID` = ".$article.";";
$bldb->query($blcomdelete);
$bldb->query($bldelete);
$bldb->close();