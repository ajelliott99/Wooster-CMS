<?php
require_once('../private/init.php');

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }
// If no ID given, redirect to homepage
if(!isset($_GET['id'])){ header("Location: index.php"); }

// If there is a type, store that as t
t = $_GET['type'];

// Holds info about the post or tag being edited
$tag_info = [];
$post_info = [];

// Assigns variables according to whether post or tag
if(t == "tag"){
	$tag_info['TagID'] = $_GET['id'];
}elseif(t == "post"){
	$post_info['PostID'] = $_GET['id'];
}

// If POST request
if($_SERVER['REQUEST_METHOD'] === "POST"){
	
	if(t == "tag"){
		$tag_info['Name'] = $_POST['name'] ?? "";
		$tag_info['Description'] = $_POST['desc'] ?? "";
		
		$errors = update_tag($conn, $tag_info['TagID'], $tag_info['Name'], $tag_info['Description']);
		if(!empty($errors)){
			echo "Errors in edit.php";
		}else{
			header("Location: tags.php");
		}
		
	}elseif(t == "post"){
		$post_info['TagID'] = $_POST['tagid'];
		$post_info['Weight'] = $_POST['weight'];
		$post_info['Visible'] = $_POST['visible'];
		$post_info['Title'] = $_POST['title'];
		$post_info['Subtitle'] = $_POST['subtitle'];
		$post_info['Content'] = $_POST['content'];
		
		$errors = update_post($conn, $post_info['TagID'], $post_info['Weight'], $post_info['Visible'], $post_info['Title'], $post_info['Subtitle'], $post_info['Content']);
		if(!empty($errors)){
			echo "Errors in edit.php";
		}else{
			header("Location: posts.php");
		}
	}
	
	
	
// If GET request
}elseif($_SERVER['REQUEST_METHOD'] === "GET"){
	
	if(!isset($_GET['id'])){ 
		header('Location: index.php'); 
	}
	
	$tag = get_tag_by_id($conn, $_GET['id']);
	$tag_info['TagID'] = $_GET['id'];
	$tag_info['Name'] = $tag['Name'];
	$tag_info['Description'] = $tag['Description'];
	

	
}

require_once(PRIVATE_PATH . '/templates/header.php');
?>
<?php
if($_GET['type'] == "tag"){ ?>
	<h1>Edit Tag</h1>
	<form action="<?php echo 'edit.php?type=tag&id=' . $tag_info['TagID']?>" method="post">
		<p> ID: <?php echo h($tag_info['TagID']); ?></p>
		<label>Name: 
		<input type="text" name="name" id="name" value="<?php echo h($tag_info['Name']); ?>"></input>
		</label></br>
		<label>Description: 
		<input type="text" name="desc" id="desc" size="50" value="<?php echo h($tag_info['Description']); ?>"></input>
		</label></br>
		<input type="submit" name="submit" id="submit" value="Submit"></input>
	</form>
<?php }elseif(){ ?>
	<h1> Edit Post </h1>
	<form action="<?php echo 'edit.php?type=post';?>" method="post" class="create-new-form">
		<input type="text" name="title" id="title" placeholder="Title"></input>
		</br>
		<input type="text" name="subtitle" id="subtitle" size="100" placeholder="Subtitle"></input>
		</br>
		<input type="text" name="tagid" id="tagid" size="6" placeholder="Tag"></input>
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