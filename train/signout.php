<?php
session_start();
$old_user = $_SESSION['valid_user'];
unset($_SESSION['valid_user']);
session_destroy();

if(!empty($old_user)) 
{
	echo '<meta http-equiv="refresh" content="0;url=http://www.scuisdc.com/train/index.php"> ';
}

?>
