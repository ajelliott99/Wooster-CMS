<?php

// Logs in the user by updating session info. $user is an assoc array with user info from db
function login_user($user){
	session_regenerate_id();
	$_SESSION['admin_id'] = $user['id'];
	$_SESSION['first_name'] = $user['first_name'];
	echo "logged in.";
}

function is_logged_in(){
	if(isset($_SESSION['admin_id'])){
		return true;
	}else{
		return false;
	}
}
?>