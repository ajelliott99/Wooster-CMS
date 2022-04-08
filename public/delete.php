<?php
require_once('../private/init.php');

$delete_type = $_GET['type'];
$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === "POST"){
	if(isset($_POST['yes'])){
		if($delete_type == "tag"){
			delete_tag($conn, $id);
			header("Location: tags.php");
		}
		
	}else{
		echo "nope";
	}
}else{
	
}

?>
<form action="delete.php?type=tag&id=<?php echo $id; ?>" method="post">
	<p> Are you sure you want to delete? </p>
	<input type="submit" name="yes" id="yes" value="yes"></input>
	<input type="submit" name="no" id="no" value="no"></input>
</form>