<?php

require_once('../blog/wp-load.php');

function validate_login() {
	if ( $user_id = is_user_logged_in() ) {
		$user = wp_get_current_user();
		$user_name = $user->user_firstname . $user_id->user_lastname;
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

?>