<?php
require_once('../private/init.php');
if(!is_logged_in()){ header("Location: index.php"); } 

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }

// If there is a type, store that as t
$t = $_GET['type'];

// Holds info about the post or tag being created
$tag_info = [];
$post_info = [];

// If POST request
if($_SERVER['REQUEST_METHOD'] === "POST"){
	
	if($t == "tag"){
		$tag_info['Name'] = $_POST['name'] ?? "";
		$tag_info['Description'] = $_POST['desc'] ?? "";
		
		$errors = create_tag($conn, $tag_info['Name'], $tag_info['Description']);
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
		
		$errors = create_post($conn, $post_info['TagID'], $post_info['Weight'], $post_info['Visible'], $post_info['Title'], $post_info['Subtitle'], $post_info['Content'], $post_info['Author']);
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			header("Location: posts.php");
		}
	}
	
	
// If GET request
}elseif($_SERVER['REQUEST_METHOD'] === "GET"){
	

	
}

require_once(PRIVATE_PATH . '/templates/header.php');
?>
<?php
if($t == "tag"){ ?>
	<form action="<?php echo 'create.php?type=tag';?>" method="post" class="create-new-form">
		<h1>Create New Tag</h1>
		<input type="text" name="name" id="name" placeholder="Name"></input>
		</br>
		<input type="text" name="desc" id="desc" size="50" placeholder="Description"></input>
		</br>
		<input type="submit" name="submit" id="submit" value="Create"></input>
	</form>
	
<?php 
}elseif($t == "post"){ ?>
	<form action="<?php echo 'create.php?type=post';?>" method="post" class="create-new-form">
		<h1>Create New Post</h1>
		<input type="text" name="title" id="title" placeholder="Title"></input>
		</br>
		<input type="text" name="subtitle" id="subtitle" size="100" placeholder="Subtitle"></input>
		</br>
		<input type="text" name="author" id="author" placeholder="Author"></input>
		</br>
		<input type="text" name="tagid" id="tagid" size="6" placeholder="Tag ID"></input>
		</br>
		<input type="text" name="weight" id="weight" size="6" placeholder="Weight"></input>
		</br>
		<input type="text" name="visible" id="visible" size="6" placeholder="Visible"></input>
		</br>
		<input type="text" name="content" id="content" size="500" placeholder="Content"></input>
		</br>
		<input type="submit" name="submit" id="submit" value="Create"></input>
	</form>
<?php } ?>