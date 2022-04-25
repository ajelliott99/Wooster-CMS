<?php 
require_once('../private/init.php');
if(is_logged_in()){
	header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] === "POST"){
	if(empty($_POST['email']) or empty($_POST['password'])){
		echo "Please complete all fields.";
		header("Location: login.php");
	}
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$login_failure_msg = "Login unsuccessful.";
	
	$admin = get_admin_by_email($conn, $email);
	if($admin) {
      if(password_verify($password, $admin['hashed_password'])) {
        // password matches
        login_user($admin);
        header("Location: index.php");
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }
}
?>

<?php require_once(PRIVATE_PATH . '/templates/header.php');  ?>

<form action="login.php" method="POST">
	<label for="email">email:</label><br>
	<input type="text" name="email" id="email"></input></br>
	<label for="password">password:</label><br>
	<input type="password" name="password" id="password"></input>
	<input type="submit" name="submit" value="submit"></input>
</form>

<?php require_once(PRIVATE_PATH . '/templates/footer.php') ?>