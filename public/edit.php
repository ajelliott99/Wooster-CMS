<?php
require_once('../private/init.php');

$tag_info = [];
$tag_info['TagID'] = $_GET['id'];

// If POST request
if($_SERVER['REQUEST_METHOD'] === "POST"){
	
	$tag_info['Name'] = $_POST['name'] ?? "";
	$tag_info['Description'] = $_POST['desc'] ?? "";
	
	$errors = update_tag($conn, $tag_info['TagID'], $tag_info['Name'], $tag_info['Description']);
	if(!empty($errors)){
		echo "Errors in edit.php";
	}else{
		header("Location: tags.php");
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
<?php }elseif($_GET['type'] == "post"){ ?>
	<h1> hello post </h1>
<?php } ?>