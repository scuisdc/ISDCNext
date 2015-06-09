<?php
session_start();
$captcha = $_SESSION["code"];
$user_cap = $_POST["user"];
$captcha = strtolower($captcha);
$user_cap = strtolower($user_cap);
if ($captcha == $user_cap) {
    echo "1";
}
else {
    echo "0";
}

?>
