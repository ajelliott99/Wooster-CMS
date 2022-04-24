<!DOCTYPE HTML> 

<html lang="en">
	<head>
		<title> Wooster Content Management </title>
		<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" href="<?php echo WWW_ROOT . '/styles/primary.css';?>">
	</head>

	<body>
		<header>
			<h1> Wooster CMS </h1>
			<?php if(is_logged_in()){ echo "<p>Welcome, " . $_SESSION['first_name'] . "</p>"; } ?>
		</header>
		
		<nav>
			<ul>
				<li><a href="<?php echo WWW_ROOT . '/index.php'; ?>"> Home </a> </li>
				<li><a href="<?php echo WWW_ROOT . '/tags.php'; ?>"> Tags </a></li>
				<li><a href="<?php echo WWW_ROOT . '/posts.php'; ?>"> Posts </a></li>
				<?php if(!is_logged_in()){ echo "<li><a href=" . WWW_ROOT . '/login.php' . "> Login </a></li>"; } ?>
				<?php if(is_logged_in()){ echo "<li><a href=" . WWW_ROOT . '/signup.php' . "> Create Admin </a></li>"; } ?>
				<?php if(is_logged_in()){ echo "<li><a href=" . WWW_ROOT . '/logout.php' . "> Logout </a></li>"; } ?>
			</ul>
		</nav>