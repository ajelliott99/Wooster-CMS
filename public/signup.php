<?php 
require_once('../private/init.php'); 

//if(!is_logged_in()){ header("Location: index.php"); } 

$admin_info = [];
$errors = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
	$admin_info['id'] = -1;
	$admin_info['first_name'] = $_POST['firstname'] ?? "";
	$admin_info['last_name'] = $_POST['lastname'] ?? "";
	$admin_info['email'] = $_POST['email'] ?? "";
	$admin_info['username'] = $_POST['username'] ?? "";
	$admin_info['password'] = $_POST['password'];

	$errors = create_admin($conn, $admin_info);
	if(!empty($errors)){
		// error creating account
		echo display_errors($errors);
	}else{
		// redirect with success message
		header("Location: admins.php");
	}
}
?>

<?php require_once(PRIVATE_PATH . '/templates/header.php');  ?>
<ul class="errors-list">
	
</ul>
<div class="form-container">
<form action="signup.php" method="POST">
	<h1> Create admin </h1>
	<label for="firstname">first name:</label><br>
	<input type="text" name="firstname" id="firstname"></input></br>
	<label for="lastname">last name:</label><br>
	<input type="text" name="lastname" id="lastname"></input></br>
	<label for="email">email:</label><br>
	<input type="text" name="email" id="email"></input></br>
	<label for="username">username:</label><br>
	<input type="text" name="username" id="username"></input></br>
	<label for="password">password:</label><br>
	<input type="password" name="password" id="password"></input>
	<input type="submit" name="submit" value="submit"></input>
</form>
</div>