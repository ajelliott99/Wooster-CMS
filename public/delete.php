<?php
require_once('../private/init.php');

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }
// If no ID given, redirect to homepage
if(!isset($_GET['id'])){ header("Location: index.php"); }

$delete_type = $_GET['type'];
$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === "POST"){
	if(isset($_POST['yes'])){
		if($delete_type == "tag"){
			delete_tag($conn, $id);
			header("Location: tags.php");
		}elseif($delete_type == "post"){
			delete_post($conn, $id);
			header("Location: posts.php");
		}
		
	}else{
		// If user selects no, redirect based on what type was being deleted
		if($delete_type == "tag"){ header("Location: tags.php");
		}elseif($delete_type == "post"){ header("Location: posts.php"); }
	}
}elseif($_SERVER['REQUEST_METHOD'] === "GET"){
	
}

?>
<form action="delete.php?type=<?php echo $delete_type; ?>&id=<?php echo $id; ?>" method="post">
	<p> Are you sure you want to delete? </p>
	<input type="submit" name="yes" id="yes" value="yes"></input>
	<input type="submit" name="no" id="no" value="no"></input>
</form>