<?php
// This file is included with database.php
// Use $conn for database connection_aborted

// Returns an array of dictionaries with tag info. Ex: tags[0]['Name']
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
	$query .= "WHERE TagID='" . db_escape($connection, $id) . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function update_tag($connection, $id, $name, $desc){
	$query = "UPDATE tags ";
	$query .= "SET Name='" . db_escape($connection, $name) . "', ";
	$query .= "Description='" . db_escape($connection, $desc) . "' ";
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
	$query .= "VALUES ('" . db_escape($connection, $name) . "', '" . db_escape($connection, $desc) . "') ";
	
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

// Returns an array of dictionaries with post info. Ex: posts[0]['Content']
function get_all_posts($connection){
	$data = array();
	
	$query = "SELECT * FROM posts";
	$result = mysqli_query($connection, $query);
	
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}
	
	mysqli_free_result($result);
	return $data;
}

function create_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content){
	$errors = validate_post($tagid, $weight, $visible, $title, $subtitle, $content);
	
	$query = "INSERT INTO posts (TagID, Weight, Visible, Title, Subtitle, Content) ";
	$query .= "VALUES ('" . db_escape($connection, $tagid) . "', '" . db_escape($connection, $weight) . "', '" . db_escape($connection, $visible) . "', '" . db_escape($connection, $title) . "', '" . db_escape($connection, $subtitle) . "', '" . db_escape($connection, $content) . "') ";

	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = "Database Error. Add more details later.";
		}
	}
	
	return $errors;
}

function update_post($connection, $postid, $tagid, $weight, $visible, $title, $subtitle, $content){
	$query = "UPDATE posts ";
	$query .= "SET TagID='" . db_escape($connection, $tagid) . "', ";
	$query .= "Weight='" . db_escape($connection, $weight) . "' ";
	$query .= "Visible='" . db_escape($connection, $visible) . "' ";
	$query .= "Title='" . db_escape($connection, $title) . "' ";
	$query .= "Subtitle='" . db_escape($connection, $subtitle) . "' ";
	$query .= "Content='" . db_escape($connection, $content) . "' ";
	$query .= "WHERE PostID='" . $postid . "'";
	
	$errors = validate_post($tagid, $weight, $visible, $title, $subtitle, $content);
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = "Database Error. Add more details later.";
		}
	}
	
	return $errors;
}

function validate_tag($name, $desc){
	$errors = [];
	
	return $errors;
}

function validate_post($tagid, $weight, $visible, $title, $subtitle, $content){
	$errors = [];
	
	return $errors;
}
?>