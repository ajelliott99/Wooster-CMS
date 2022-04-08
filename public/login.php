<?php 
require_once('../private/init.php'); 
require_once(PRIVATE_PATH . '/templates/header.php'); 


}
?>

<form action="login.php" method="POST">
	<label for="username">username:</label><br>
	<input type="text" name="username" id="username"></input></br>
	<label for="password">password:</label><br>
	<input type="text" name="password" id="password"></input>
	<input type="submit" name="submit" value="submit"></input>
</form>

<?php require_once(PRIVATE_PATH . '/templates/footer.php') ?>