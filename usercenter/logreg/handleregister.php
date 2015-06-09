<?php
session_start();
require_once("../../glorious/glorious.php");
require_once("../../glorious/config.php");

$email = trim($_POST['email']);
$passwd = trim($_POST['passwd']);
$userid = trim($_POST['userid']);
$nick = trim($_POST['nick']);

$passwd = md5(sha1($passwd));

if (!isset($email) || !isset($passwd) || !isset($userid) || !isset($nick)) {
    header('Location: http://www.scuisdc.com/404');
    die();
}

$db = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_UC_User, DBConfig::$DB_UC_Pass, DBConfig::$DB_UC_Name);
if ($db->state() == 1) {
    $db->setTable("user");
    $db->where([
        "username" => $userid,
        "email" => $email
    ], "or");
    $res = $db->find(["ID"]);
    if (count($res) == 0) {
        $db->insert([
            "email" => $email,
            "passwd" => $passwd,
            "username" => $userid,
            "displayname" => $nick,
            "privilege" => '1'
        ]);
        $_SESSION["valid_user"] = $userid;
        echo "success";
    }
    else {
        echo "exist";
    }
} else {
    echo 'dberror';
}
$db->destroy();

?>
