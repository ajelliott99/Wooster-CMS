<?php
require_once('../private/init.php');

if($_SERVER['REQUEST_METHOD'] === "POST"){
	// Confirm that user wants to log out
	if(isset($_POST['yes'])){
		// Double check that they're actually logged in...I guess this isn't really necessary?
		if(is_logged_in()){
			unset($_SESSION['admin_id']);
			unset($_SESSION['first_name']);
			header("Location: index.php");
		}else{
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
}

?>

<form action="logout.php" method="post">
	<p> Are you sure you want to log out? </p>
	<input type="submit" name="yes" id="yes" value="yes"></input>
	<input type="submit" name="no" id="no" value="no"></input>
</form>