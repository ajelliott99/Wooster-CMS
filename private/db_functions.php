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
			$errors[] = mysqli_connect_error();
		}
	}
	
	return $errors;
}

function delete_tag($connection, $id){
	$query = "DELETE FROM tags ";
	$query .= "WHERE TagID='" . db_escape($connection, $id) . "'";

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

function create_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$errors = validate_post($tagid, $weight, $visible, $title, $subtitle, $content, $author);
	
	$query = "INSERT INTO posts (TagID, Weight, Visible, Title, Subtitle, Content, Author) ";
	$query .= "VALUES ('" . db_escape($connection, $tagid) . "', '" . db_escape($connection, $weight) . "', '" . db_escape($connection, $visible) . "', '" . db_escape($connection, $title) . "', '" . db_escape($connection, $subtitle) . "', '" . db_escape($connection, $content) . "', '" . db_escape($connection, $author) . "') ";

	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
		}
	}
	
	return $errors;
}

function update_post($connection, $postid, $tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$query = "UPDATE posts ";
	$query .= "SET TagID='" . db_escape($connection, $tagid) . "', ";
	$query .= "Weight='" . db_escape($connection, $weight) . "', ";
	$query .= "Visible='" . db_escape($connection, $visible) . "', ";
	$query .= "Title='" . db_escape($connection, $title) . "', ";
	$query .= "Subtitle='" . db_escape($connection, $subtitle) . "', ";
	$query .= "Content='" . db_escape($connection, $content) . "', ";
	$query .= "Author='" . db_escape($connection, $author) . "' ";
	$query .= "WHERE PostID='" . $postid . "'";
	echo $query;
	$errors = validate_post($tagid, $weight, $visible, $title, $subtitle, $content, $author);
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
		}
	}
	
	return $errors;
}

function get_post_by_id($connection, $id){
	
	$query = "SELECT * FROM posts ";
	$query .= "WHERE PostID='" . db_escape($connection, $id) . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function delete_post($connection, $id){
	$query = "DELETE FROM posts ";
	$query .= "WHERE PostID='" . db_escape($connection, $id) . "'";

	$result = mysqli_query($connection, $query);
	return $result;
}

function create_admin($connection, $admin_info){
	$errors = validate_signup_info($connection, $admin_info['username'], $admin_info['email'], $admin_info['password']);

	if(empty($errors)){
		$admin_info['hashed_password'] = password_hash($admin_info['password'], PASSWORD_BCRYPT);
		
		$query = "INSERT INTO admins (first_name, last_name, email, username, hashed_password) ";
		$query .= "VALUES ('" . db_escape($connection, $admin_info['firstname']) . "', '" . db_escape($connection, $admin_info['lastname']) . "', '" . db_escape($connection, $admin_info['email']) . "', '" . db_escape($connection, $admin_info['username']) . "', '" . db_escape($connection, $admin_info['hashed_password']) . "') ";
		
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
		}
	}
	
	return $errors;
}

function get_admin_by_username($connection, $username){
	$errors = [];
	
	$query = "SELECT * FROM admins ";
	$query .= "WHERE username='" . db_escape($connection, $username) . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function get_admin_by_email($connection, $email){
	$errors = [];
	
	$query = "SELECT * FROM admins ";
	$query .= "WHERE email='" . db_escape($connection, $email) . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function delete_admin($connection, $id){
	
}

function validate_tag($name, $desc){
	$errors = [];
	
	return $errors;
}

function validate_post($tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$errors = [];
	
	return $errors;
}

// Very basic validation functions for creating admins 
// TO DO: Add more validations to increase data reliability 
function validate_signup_info($connection, $username, $email, $password){
	$errors = [];
	
	// Validate username
	if(empty($username)){
		$errors[] = "Username cannot be blank.";
	}elseif(strlen($username) < 4){
		$errors[] = "Username must be at least 4 characters.";
	}elseif(strlen($username) > 30){
		$errors[] = "Username cannot be more than 30 characters.";
	}elseif(!empty(get_admin_by_username($connection, $username))){
		$errors[] = "Username taken.";
	}
	
	// Validate email
	$email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
	if(empty($email)){
		$errors[] = "Email cannot be empty";
	}elseif(!preg_match($email_regex, $email)){
		$errors[] = "Invalid email format.";
	}
	
	// Validate password
	if(empty($password)){
		$errors[] = "Password cannot be empty.";
	}elseif(strlen($password) < 6){
		$errors[] = "Password must be at least 6 characters.";
	}elseif(strlen($password) > 50){
		$errors[] = "Password cannot be over 50 characters.";
	}
	
	
	return $errors;
}
?>