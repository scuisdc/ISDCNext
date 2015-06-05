<?php
session_start();

header("Content-Type: text/html;charset=utf-8");
require_once("./private/isdcoj-config.php");
require_once("./ioj-mission-start.php");
require_once("./sqlin.php");
require_once('./include/ioj-util-second.php');

$checkCode = $_POST['checkCode'];
$checkCode = strtoupper($checkCode);


$DECUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
$id = trim($_POST['id']);

if (!is_numeric($id)){
    echo "<script>alert('invalid id');</script>";
    header("Location: http://www.scuisdc.com/train/");
    exit();
}

$db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
ioj_check_db_error();
$db->query("set character set 'utf8'");
$db->query("set names 'utf8'");
$query = "SELECT * FROM " . ISDCOJ_MYSQL_TBISSUE . " WHERE `ID`=".$id;
$result = $db->query($query);
if($row = $result->fetch_array(MYSQLI_ASSOC)){
    $ptitle = $row[$IOJ_ISSUESC["title"]];
    $pid = $row[$IOJ_ISSUESC["id"]];
    $endtime = $row[$IOJ_ISSUESC["end"]];
    $starttime = $row[$IOJ_ISSUESC["begin"]];
    $language = $row[$IOJ_ISSUESC["language"]];
    $rank = $row[$IOJ_ISSUESC["rank"]];
    $numofacc = $row[$IOJ_ISSUESC["numofAC"]];
    $numofsub = $row[$IOJ_ISSUESC["numofSUB"]];
    $memlim = $row[$IOJ_ISSUESC["space_comp"]];
    $timelim = $row[$IOJ_ISSUESC["time_comp"]];
    $is_auto = $row[$IOJ_ISSUESC["is_auto"]];
    $description = $row[$IOJ_ISSUESC["description"]];
    $in = $row[$IOJ_ISSUESC["in"]];
    $out = $row[$IOJ_ISSUESC["out"]];
    $enable = $row[$IOJ_ISSUESC["enable"]];
    if (!$enable){
        header("Location: http://www.scuisdc.com/train/");
        echo "<script>alert('invalid problem');</script>";
        exit();
    }
}
else {
    header("Location: http://www.scuisdc.com/train/");
    echo "<script>alert('invalid id');</script>";
    exit();
}
$result->close();
$db->close();
if (isset($_SESSION['valid_user'])) {
    $username = $_SESSION['valid_user'];
}
else{
    echo "<script>alert('invalid user');</script>";
    header("Location: http://www.scuisdc.com/train/");
}
$username = sqlin($username);
$db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCUC_MYSQL_DBNAME);
ioj_check_db_error();
$db->query("set character set 'utf8'");
$db->query("set names 'utf8'");
$query = "SELECT * FROM " . ISDCUC_MYSQL_TBUSER . " WHERE `username`='".$username."'";
$result = $db->query($query);
if($row = $result->fetch_array(MYSQLI_ASSOC)){
    $userid = $row["ID"];
}
else {
    header("Location: http://www.scuisdc.com/train/");
    echo "<script>alert('invalid id');</script>";
    exit();
}
$result->close();
$db->close();

$textarea = trim($_POST['textarea']);
$languageid = trim($_POST['language_sel']);
$language_sel = $IOJ_LANGUAGE[$languageid];
if($_SESSION['cc'] != $checkCode)
{
	echo '<script>alert("验证码输入错误!!!");</script>';
	echo '<script>window.location.href="./problemdescription.php?id='.$id.'"</script>';
	exit();
}


$now = time();
$structure = './TPD/problem/'.$id."/answer/";

if($language_sel == "C++") {
    $filedir = $structure . "cpp/" . $username . "_" . $now . ".cpp";
    $filename = "cpp/" . $username . "_" . $now . ".cpp";
}
else if($language_sel == "java"){
	$filedir = $structure."java/".$username."_".$now.".java";
    $filename = "java/".$username."_".$now.".java";
}
else if($language_sel == "py"){
	$filedir = $structure."py/".$username."_".$now.".py";
    $filename = "py/".$username."_".$now.".py";
}
else if($language_sel == "C"){
	$filedir = $structure."c/".$username."_".$now.".c";
    $filename = "c/".$username."_".$now.".c";
}
else if($language_sel == "php"){
	$filedir = $structure."php/".$username."_".$now.".php";
    $filename = "php/".$username."_".$now.".php";
}
$myfile = fopen($filedir, "w");
echo "<br />";
fwrite($myfile, $textarea);
if(!$myfile)
{
	echo '<title>unsuccessful</title>';
	echo '<script>alert("Unsuccessful");</script>';
    header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
    exit();
}
else {
    echo '<title>successful</title>';

    $db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
    $db->query("SET NAMES UTF8"); #防止中文乱码
    if (mysqli_connect_errno()) {
        echo '<script>alert("服务器连接错误！提交失败！");</script>';
        header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
        exit();
    }
    $insert = "INSERT INTO `" . ISDCOJ_MYSQL_DBNAME . "`.`" . ISDCOJ_MYSQL_TBSUBMIT . "` " .
        "(`ID`, `problem_ID`, `submiter_ID`, `language`, `status`, `run_time`, `run_memory`, `message`) " .
        "VALUES (NULL, '" . $id . "', '" . $userid . "', '" . $languageid . "', NULL, NULL, NULL, NULL);";
    $db->query($insert);
    $submitid = $db->insert_id;
    $db->close();

    $db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
    $db->query("SET NAMES UTF8"); #防止中文乱码
    if (mysqli_connect_errno()) {
        echo '<script>alert("服务器连接错误！提交失败！");</script>';
        header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
        exit();
    }
    $insert = "INSERT INTO `" . ISDCOJ_MYSQL_DBNAME . "`.`" . ISDCOJ_MYSQL_TBSOURCE . "` (`ID`, `submit_ID`, `file_path`) " .
        "VALUES (NULL, '" . $submitid . "', '" . $filedir . "');";
    $db->query($insert);
    $db->close();

    fclose($myfile);

    if ($is_auto) {
        $socket_port = 23333;
        $socket_address = "127.0.0.1";
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        echo "<h1>" . $socket . "</h1>";
        if ($socket === false) {
            echo '<script>alert("服务器连接错误！提交失败！1");</script>';
            header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
        }
        $result = socket_connect($socket, $socket_address, $socket_port);
        if ($result === false) {
            echo '<script>alert("服务器连接错误！提交失败！2");</script>';
            header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
            exit();
        }

        $sendmsg = "\$AUTH";
        echo "<h1>" . $sendmsg . "</h1>";
        $receivemsg = "";
        socket_write($socket, $sendmsg, strlen($sendmsg));
        $receivemsg = socket_read($socket, 1024);
        echo "<h1>" . $receivemsg . "</h1>";
        if ($receivemsg != 1) {
            echo '<script>alert("服务器连接错误！提交失败！3");</script>';
            header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
            exit();
        }
        $rootdir = $DECUMENT_ROOT . "/train/TPD/problem/" . $id;
        $sendmsg = "args={" .
            "source={'" . $rootdir . "/answer/" . $filename . "'}, " .
            "language=" . $languageid . ", " .
            "flag=''" . ", " .
            "data='" . $rootdir . "/" . $id . ".in" . "'" . ", " .
            "result='" . $rootdir . "/" . $id . ".out" . "'" . ", " .
            "time=" . $timelim*1.2 . ", " .
            "mem=" . $memlim . ", " .
            "outfile='" . $DECUMENT_ROOT . "/train/TPD/" . "temp_result/" . $submitid . ".result'" .
            "}\r\nexecute(args)";
        $receivemsg = "";
        socket_write($socket, $sendmsg, strlen($sendmsg));
        $receivemsg = socket_read($socket, 1024);
        if ($receivemsg != 1) {
            echo '<script>alert("服务器连接错误！提交失败！4");</script>';
            header("Location: http://www.scuisdc.com/train/problemdescription.php?id='.$id.'");
            exit();
        }

        echo '<script>alert("提交成功!!!");</script>';
        header("Location: http://www.scuisdc.com/train/viewCodes.php?id=".$submitid);
    }
}
?>
