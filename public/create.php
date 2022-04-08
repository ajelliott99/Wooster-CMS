<?php
require_once('../private/init.php');

$tag_info = [];

// If POST request
if($_SERVER['REQUEST_METHOD'] === "POST"){
	
	$tag_info['Name'] = $_POST['name'] ?? "";
	$tag_info['Description'] = $_POST['desc'] ?? "";
	
	$errors = create_tag($conn, $tag_info['Name'], $tag_info['Description']);
	if(!empty($errors)){
		echo "Error...";
	}else{
		header("Location: tags.php");
	}
	
	
// If GET request
}elseif($_SERVER['REQUEST_METHOD'] === "GET"){
	

	
}

require_once(PRIVATE_PATH . '/templates/header.php');
?>
<?php
if($_GET['type'] == "tag"){ ?>
	<form action="<?php echo 'create.php?type=tag';?>" method="post" class="create-new-form">
		<h1>Create New Tag</h1>
		<input type="text" name="name" id="name" placeholder="Name"></input>
		</br>
		<input type="text" name="desc" id="desc" size="50" placeholder="Description"></input>
		</br>
		<input type="submit" name="submit" id="submit" value="Create"></input>
	</form>
	
<?php }elseif($_GET['type'] == "post"){ ?>
	
<?php } ?>