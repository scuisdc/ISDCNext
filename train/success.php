<html>
    <head>
    	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <title>登陆成功</title>
    </head>
    <body>
        <h1 align="center">登陆成功</h1>
	<br /><br />
	<?php
		session_start();
        	$username = $_SESSION['valid_user'];
		echo "<h3>".$username."</h3>";
	?>
	<a href="signout.php">注销</a>
	</body>
</html>
