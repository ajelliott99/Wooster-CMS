<?php
require_once('../private/init.php');
if(!is_logged_in()){ header("Location: index.php"); } 

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }
// If no ID given, redirect to homepage
if(!isset($_GET['id'])){ header("Location: index.php"); }

// If there is a type, store that as t
$t = $_GET['type'];

// Holds info about the post or tag being edited
$tag_info = [];
$post_info = [];
$admin_info = [];

// Assigns variables according to whether post or tag
if($t == "tag"){
	$tag_info['TagID'] = $_GET['id'];
}elseif($t == "post"){
	$post_info['PostID'] = $_GET['id'];
}elseif($t == "admin"){
	$admin_info['id'] = $_GET['id'];
}

// If POST request
if($_SERVER['REQUEST_METHOD'] === "POST"){
	
	if($t == "tag"){
		$tag_info['Name'] = $_POST['name'] ?? "";
		$tag_info['Description'] = $_POST['desc'] ?? "";
		
		$errors = update_tag($conn, $tag_info['TagID'], $tag_info['Name'], $tag_info['Description']);
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			header("Location: tags.php");
		}
		
	}elseif($t == "post"){
		$post_info['TagID'] = $_POST['tagid'];
		$post_info['Weight'] = $_POST['weight'];
		$post_info['Visible'] = $_POST['visible'];
		$post_info['Title'] = $_POST['title'];
		$post_info['Subtitle'] = $_POST['subtitle'];
		$post_info['Content'] = $_POST['content'];
		$post_info['Author'] = $_POST['author'];
		
		$errors = update_post($conn, $post_info['PostID'], $post_info['TagID'], $post_info['Weight'], $post_info['Visible'], $post_info['Title'], $post_info['Subtitle'], $post_info['Content'], $post_info['Author']);
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			header("Location: posts.php");
		}
	}elseif($t == "admin"){
		$admin_info['id'] = $_GET['id'];
		$admin_info['first_name'] = $_POST['first_name'];
		$admin_info['last_name'] = $_POST['last_name'];
		$admin_info['email'] = $_POST['email'];
		$admin_info['username'] = $_POST['username'];
		
		$errors = update_admin($conn, $admin_info['id'], $admin_info['first_name'], $admin_info['last_name'], $admin_info['email'], $admin_info['username']);
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			header("Location: admins.php");
		}
	}
	
	
	
// If GET request
}elseif($_SERVER['REQUEST_METHOD'] === "GET"){
	
	if($t == "tag"){
		$tag = get_tag_by_id($conn, $_GET['id']);
		$tag_info['TagID'] = $_GET['id'];
		$tag_info['Name'] = $tag['Name'];
		$tag_info['Description'] = $tag['Description'];
	}elseif($t == "post"){
		$post = get_post_by_id($conn, $_GET['id']);
		$post_info['TagID'] = $post['TagID'];
		$post_info['Weight'] = $post['Weight'];
		$post_info['Visible'] = $post['Visible'];
		$post_info['Title'] = $post['Title'];
		$post_info['Subtitle'] = $post['Subtitle'];
		$post_info['Content'] = $post['Content'];
		$post_info['Author'] = $post['Author'];
	}elseif($t == "admin"){
		$admin = get_admin_by_id($conn, $_GET['id']);
		$admin_info['first_name'] = $admin['first_name'];
		$admin_info['last_name'] = $admin['last_name'];
		$admin_info['email'] = $admin['email'];
		$admin_info['username'] = $admin['username'];
	}
}

require_once(PRIVATE_PATH . '/templates/header.php');
?>
<?php
if($t == "tag"){ ?>
	<h1>Edit Tag</h1>
	<form action="<?php echo 'edit.php?type=tag&id=' . $tag_info['TagID'];?>" method="post">
		<p> ID: <?php echo h($tag_info['TagID']); ?></p>
		<label>Name: 
		<input type="text" name="name" id="name" value="<?php echo h($tag_info['Name']); ?>"></input>
		</label></br>
		<label>Description: 
		<input type="text" name="desc" id="desc" size="50" value="<?php echo h($tag_info['Description']); ?>"></input>
		</label></br>
		<input type="submit" name="submit" id="submit" value="Update"></input>
	</form>
<?php }elseif($t == "post"){ ?>
	<h1> Edit Post </h1>
	<form action="<?php echo 'edit.php?type=post&id=' . $post_info['PostID'];?>" method="post" class="create-new-form">
		<label>Title:
			<input type="text" name="title" id="title" value="<?php echo h($post_info['Title']); ?>"></input>
		</label></br>
		<label>Subtitle:
			<input type="text" name="subtitle" id="subtitle" size="100" value="<?php echo h($post_info['Subtitle']); ?>"></input>
		</label></br>
		<label>Author:
			<input type="text" name="author" id="author" size="99" value="<?php echo h($post_info['Author']); ?>"></input>
		</label></br>
		<label>Tag ID: 
			<input type="text" name="tagid" id="tagid" size="6" value="<?php echo h($post_info['TagID']); ?>"></input>
		</label></br>
		<label>Weight:
			<input type="text" name="weight" id="weight" size="6" value="<?php echo h($post_info['Weight']); ?>"></input>
		</label></br>
		<label>Visible:
			<input type="text" name="visible" id="visible" size="6" value="<?php echo h($post_info['Visible']); ?>"></input>
		</label></br>
		<label>Content:
			<input type="text" name="content" id="content" size="500" value="<?php echo h($post_info['Content']); ?>"></input>
		</label></br>
		<input type="submit" name="submit" id="submit" value="Update"></input>
	</form>
<?php }elseif($t == "admin"){ ?>
	<h1> Edit Admin </h1>
	<form action="<?php echo 'edit.php?type=admin&id=' . $admin_info['id'];?>" method="post" class="create-new-form">
		<label>First Name:
			<input type="text" name="first_name" id="first_name" value="<?php echo h($admin_info['first_name']); ?>"></input>
		</label></br>
		<label>Last Name:
			<input type="text" name="last_name" id="last_name" size="100" value="<?php echo h($admin_info['last_name']); ?>"></input>
		</label></br>
		<label>Email:
			<input type="text" name="email" id="email" size="99" value="<?php echo h($admin_info['email']); ?>"></input>
		</label></br>
		<label>Username: 
			<input type="text" name="username" id="username" value="<?php echo h($admin_info['username']); ?>"></input>
		</label></br>
		<input type="submit" name="submit" id="submit" value="Update"></input>
	</form>
<?php } ?>