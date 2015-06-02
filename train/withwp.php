<!DOCTYPE html>
<html lang="zh-CN">

<head>

	<title>aaa</title>

	<meta charset="utf-8" />
	<meta http-equiv="Content-type" content="text/html;charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link href="/assets/css/bootstrap.css" rel="stylesheet" />
	<link href="/assets/css/bootstrap-responsive.css" rel="stylesheet" />
	<link href="/assets/css/docs.css" rel="stylesheet" />
	<link href="/assets/js/google-code-prettify/prettify.css" rel="stylesheet" />

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="/assets/ico/favicon.ico" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/ic_144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/ic_114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/ic_72.png" />
	<link rel="apple-touch-icon-precomposed" href="/assets/ico/ic_57.png" />

	<script src="/assets/js/jquery.js" type="text/javascript"></script>
	<script src="/assets/js/google-code-prettify/prettify.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-transition.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-alert.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-modal.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-dropdown.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-scrollspy.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-tab.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-tooltip.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-popover.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-button.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-collapse.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-carousel.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-typeahead.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap-affix.js" type="text/javascript"></script>
	<script src="/assets/js/application.js" type="text/javascript"></script>
	<script src="/assets/js/superfish.js" type="text/javascript"></script>
	<script src="/assets/js/custom.js" type="text/javascript"></script>

</head>

<body>

	<?php

/* $_SERVER[ 'HTTP_HOST' ] = 'localhost'; */


	require_once('../blog/wp-load.php');

	if ( $user_id = wp_validate_auth_cookie( $_COOKIE[LOGGED_IN_COOKIE], 'logged_in' ) ) {
		echo '<h1>Authed!</h1>';
		echo $user_id;
	} else {
		echo '<h1>Unauthed!</h1>';
		echo $user_id;
	}

	if ( $user_id = is_user_logged_in() ) {
		echo '<h1>Authed!</h1>';
	} else {
		echo '<h1>Unauthed!</h1>';
	}

	if ( $user_id = wp_get_current_user() ) {
		echo $user_id->user_firstname.$user_id->user_lastname;
	}


	// require_once('../blog/wp-load.php');

function validate_login() {
	if ( $user_id = is_user_logged_in() ) {
		$user = wp_get_current_user();
		$user_name = $user->user_firstname . $user->user_lastname;
		return array(true, $user_id, $user_name);
	} else {
		return false;
	}
}

function validate_login_ass() {
	$user_info = validate_login();

	if ($user_info) {
		return array('logged_in' => false);
	} else {
		return array('logged_in' => true,
					'user_id' => $user_info[2],
					'user_name' => $user_info[3]);
	}
}

	$user_info = validate_login();
	echo $user_info[2].' '.$user_info[3];
	if ( $user_info[1] ) {
		echo '<h1>你已登录为 '.$user_info[2].' '.$user_info[3].'</h1>';
	} else {
		echo '<h1>没有登录！</h1>';
	}

	?>

</body>

</html>