<?php
session_start();

require_once("/glorious/glorious.php");
require_once("/glorious/config.php");

$captcha = $_SESSION["code"];
$user_cap = $_POST["user"];
$captcha = strtolower($captcha);
$user_cap = strtolower($user_cap);
if ($captcha != $user_cap) {
    echo "captchaerror";
    exit;
}

$passwd = trim($_POST['passwd']);
$userid = trim($_POST['userid']);

$passwd = md5(sha1($passwd));

$db = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_UC_User, DBConfig::$DB_UC_Pass, DBConfig::$DB_UC_Name);
if ($db->state() == 1) {
    $db->setTable("user");
    $db->where([
        "username" => $userid,
        "passwd" => $passwd
    ]);
    $res = $db->find();
    if (count($res) > 0) {
        echo "success";
        $_SESSION["valid_user"] = $userid;
    }
    else {
        echo 'nouser';
    }
}
else {
    echo 'dberror';
}
$db->destroy();

?>
