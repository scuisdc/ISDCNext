<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/5/31
 * Time: 12:24
 */

session_start();
if (isset($_SESSION['valid_user'])) {
    $username = $_SESSION['valid_user'];
}
else{
    echo "<script>alert('invalid user');</script>";
    header("Location: http://www.scuisdc.com/train/");
}

header("Content-Type: text/html;charset=utf-8");
require_once("./private/isdcoj-config.php");
require_once("./ioj-mission-start.php");
require_once("./sqlin.php");
require_once('./include/ioj-util-second.php');

$submitid = $_POST['submitid'];
//$submitid = $_GET['submitid'];


$file_pos = $_SERVER['DOCUMENT_ROOT'] ."/train/TPD/temp_result/" . $submitid . ".result";

if (!is_numeric($submitid)){
    header("Location: http://www.scuisdc.com/hhh");
    exit();
}
$re_file = fopen($file_pos, "r");
if (!$re_file){
    echo "0";
    exit();
}
else{
    $status = fgets($re_file);
    //$whereisspace = strpos($status, ' ');
    //$status = substr($status, 0, $whereisspace);
    $tm = fgets($re_file);
    $whereisspace = strpos($tm, ' ');
    $run_time = substr($tm, 0, $whereisspace);
    $run_memory = substr($tm, $whereisspace+1);


    $message = "";
    while(!feof($re_file)) {
        $message .= fgets($re_file, 1024);
    }
    $whereisclm = strpos($message, ':');
    if ($whereisclm != 0){
        $message = substr($message, $whereisclm+1);
    }
    $updata = "UPDATE `TrainPlatform`.`oj_submit` " .
        "SET `status` = '" . $status . "', `run_time` = '" . $run_time . "', `run_memory` = '" . $run_memory . "', `message` = '" . $message . "' " .
        "WHERE `oj_submit`.`ID` = ". $submitid .";";

    $db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
    ioj_check_db_error();
    $db->query("set character set 'utf8'");
    $db->query("set names 'utf8'");
    $db->query($updata);
    $db->close();
    $msg = [
        "sutats" => $status,
        "emit_nur" => $run_time,
        "yromem_nur" => $run_memory,
        "egassem" => $message,
    ];
    echo json_encode($msg);
    fclose($re_file);
    unlink($re_file);
}

