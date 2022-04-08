<?php
// This file is included with database.php
// Use $conn for database connection_aborted

function get_all_tags($connection){
	$data = array();
	
	$query = "SELECT * FROM tags";
	$result = mysqli_query($connection, $query);
	
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}
	
	mysqli_free_result($result);
	return $data;
}

function get_tag_by_id($connection, $id){
	$errors = [];
	$errors[] = "Hello";
	
	$query = "SELECT * FROM tags ";
	$query .= "WHERE TagID='" . $id . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function update_tag($connection, $id, $name, $desc){
	$query = "UPDATE tags ";
	$query .= "SET Name='" . h($name) . "', ";
	$query .= "Description='" . h($desc) . "' ";
	$query .= "WHERE TagID='" . $id . "'";
	
	$errors = validate_tag($name, $desc);
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = "Database Error. Add more details later.";
		}
	}
	
	return $errors;
}

function create_tag($connection, $name, $desc){
	$query = "INSERT INTO tags (Name, Description) ";
	$query .= "VALUES ('" . $name . "', '" . $desc . "') ";
	
	$errors = validate_tag($name, $desc);
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = "Database Error. Add more details later.";
		}
	}
	
	return $errors;
}

function delete_tag($connection, $id){
	$query = "DELETE FROM tags ";
	$query .= "WHERE TagID='" . $id . "'";

	$result = mysqli_query($connection, $query);
	return $result;
}

function validate_tag($name, $desc){
	$errors = [];
	
	return $errors;
}

function validate_post($post){
	$errors = [];
	
	return $errors;
}
?>