<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/9
 * Time: 15:11
 */
require_once("./private/next_config.php");
$service = $_POST['service'];
$able = $_POST['able'];
$psdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_PSDBNAME);
$psdb->query("set character set 'utf8'");
$psdb->query("set names 'utf8'");

if ($able == 'enable'){
    $data = 'disable';
    $psupdate = "UPDATE `PublicService`.`service` SET `enable` = '0' WHERE `service`.`ID` = ".$service.";";
}
else{
    $data = 'enable';
    $psupdate = "UPDATE `PublicService`.`service` SET `enable` = '1' WHERE `service`.`ID` = ".$service.";";
}
$psdb->query($psupdate);
$psdb->close();
echo $data;