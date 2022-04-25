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
// Sorted by most recently updated
function get_all_posts($connection){
	$data = array();
	
	$query = "SELECT * FROM posts ";
	$query .= "ORDER BY Updated DESC";
	$result = mysqli_query($connection, $query);
	
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}
	
	mysqli_free_result($result);
	return $data;
}

// Returns an array of dictionaries with post info, sorted by weight, the higher weights appearing at the top.
function get_all_posts_by_weight($connection){
	$data = array();
	
	$query = "SELECT * FROM posts ";
	$query .= "ORDER BY Weight DESC";
	$result = mysqli_query($connection, $query);
	
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}
	
	mysqli_free_result($result);
	return $data;
}

function get_all_posts_by_tag_id($connection, $id){
	$data = array();
	
	$query = "SELECT * FROM posts ";
	$query .= "WHERE TagID=" . $id . " ";
	$query .= "ORDER BY Weight DESC";
	$result = mysqli_query($connection, $query);
	
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}
	
	mysqli_free_result($result);
	return $data;
}

function create_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$errors = validate_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content, $author);
	
	$timestamp = date('Y-m-d H:i:s');
	
	$query = "INSERT INTO posts (TagID, Weight, Visible, Title, Subtitle, Content, Author, Updated) ";
	$query .= "VALUES ('" . db_escape($connection, $tagid) . "', '" . db_escape($connection, $weight) . "', '" . db_escape($connection, $visible) . "', '" . db_escape($connection, $title) . "', '" . db_escape($connection, $subtitle) . "', '" . db_escape($connection, $content) . "', '" . db_escape($connection, $author) . "', '" . db_escape($connection, $timestamp) . "') ";
	
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
			echo "There was an error.";
		}
	}
	
	return $errors;
}

function update_post($connection, $postid, $tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$errors = validate_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content, $author);
	
	$timestamp = date('Y-m-d H:i:s');
	
	$query = "UPDATE posts ";
	$query .= "SET TagID='" . db_escape($connection, $tagid) . "', ";
	$query .= "Weight='" . db_escape($connection, $weight) . "', ";
	$query .= "Visible='" . db_escape($connection, $visible) . "', ";
	$query .= "Title='" . db_escape($connection, $title) . "', ";
	$query .= "Subtitle='" . db_escape($connection, $subtitle) . "', ";
	$query .= "Content='" . db_escape($connection, $content) . "', ";
	$query .= "Author='" . db_escape($connection, $author) . "', ";
	$query .= "Updated='" . $timestamp . "' ";
	$query .= "WHERE PostID='" . $postid . "'";
	
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
			echo "There was an error.";
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
	$errors = validate_signup_info($connection, $admin_info['username'], $admin_info['email'], $admin_info['password'], $admin_info['first_name'], $admin_info['last_name']);

	if(empty($errors)){
		$admin_info['hashed_password'] = password_hash($admin_info['password'], PASSWORD_BCRYPT);
		
		$query = "INSERT INTO admins (first_name, last_name, email, username, hashed_password) ";
		$query .= "VALUES ('" . db_escape($connection, $admin_info['first_name']) . "', '" . db_escape($connection, $admin_info['last_name']) . "', '" . db_escape($connection, $admin_info['email']) . "', '" . db_escape($connection, $admin_info['username']) . "', '" . db_escape($connection, $admin_info['hashed_password']) . "') ";
		
		$errors = validate_admin($connection, $admin_info['id'], $admin_info['first_name'], $admin_info['last_name'], $admin_info['email'], $admin_info['username']);
		
		if(empty($errors)){
			$result = mysqli_query($connection, $query);
			if(!$result){
				$errors[] = mysqli_connect_error();
			}
		}
	}
	
	return $errors;
}

function get_all_admins($connection){
	$errors = [];
	
	$query = "SELECT * FROM admins";
	$result = mysqli_query($connection, $query);
	
	$data = array();
	while($fetch = mysqli_fetch_assoc($result)){
		array_push($data, $fetch);
	}

	mysqli_free_result($result);
	return $data;
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

function get_admin_by_id($connection, $id){
	$errors = [];
	
	$query = "SELECT * FROM admins ";
	$query .= "WHERE id='" . db_escape($connection, $id) . "' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	$data = mysqli_fetch_assoc($result);

	mysqli_free_result($result);
	return $data;
}

function update_admin($connection, $id, $first_name, $last_name, $email, $username){
	$query = "UPDATE admins ";
	$query .= "SET first_name='" . db_escape($connection, $first_name) . "', ";
	$query .= "last_name='" . db_escape($connection, $last_name) . "', ";
	$query .= "email='" . db_escape($connection, $email) . "', ";
	$query .= "username='" . db_escape($connection, $username) . "' ";
	$query .= "WHERE id='" . $id . "'";

	$errors = validate_admin($connection, $id, $first_name, $last_name, $email, $username);
	if(empty($errors)){
		$result = mysqli_query($connection, $query);
		if(!$result){
			$errors[] = mysqli_connect_error();
		}
	}
	
	return $errors;
}

function delete_admin($connection, $id){
	$query = "DELETE FROM admins ";
	$query .= "WHERE id='" . db_escape($connection, $id) . "' ";
	$query .= "LIMIT 1";

	$result = mysqli_query($connection, $query);
	return $result;
}

function tag_exists($connection, $tagid){
	$result = get_tag_by_id($connection, $tagid);
	if(!empty($result)){
		return true;
	}else{
		return false;
	}
}

function validate_tag($name, $desc){
	$errors = [];
	
	// Validate name
	if(empty($name)){
		$errors[] = "Name cannot be empty.";
	}elseif(strlen($name) > 99){
		$errors[] = "Name cannot exceed 99 characters.";
	}
	
	// Validate description
	if(empty($desc)){
		$errors[] = "Description cannot be empty.";
	}elseif(strlen($desc) > 500){
		$errors[] = "Description cannot exceed 500 characters.";
	}
	
	return $errors;
}

function validate_post($connection, $tagid, $weight, $visible, $title, $subtitle, $content, $author){
	$errors = [];
	
	// Validate TagID
	if(empty($tagid)){
		$errors[] = "Tag ID cannot be empty";
	}elseif(!tag_exists($connection, $tagid)){
		$errors[] = "Tag does not exist. Please enter a valid Tag ID. To view available tags, see Tags tab.";
	}
	
	// Validate weight
	if(empty($weight)){
		$errors[] = "Weight cannot be empty.";
	}elseif(intval($weight) == 0){
		$errors[] = "Please enter a valid weight, 1-100";
	}
	
	// Validate visible
	if(empty($visible)){
		$errors[] = "Visible cannot be empty.";
	}elseif($visible != "0" and $visible != "1"){
		$errors[] = "Invalid visible value. 0 = Not visible 1 = Visible";
	}
	
	// Validate title
	if(empty($title)){
		$errors[] = "Title cannot be empty.";
	}elseif(strlen($title) > 200){
		$errors[] = "Title cannot exceed 200 characters.";
	}
	
	// Validate subtitle
	if(empty($subtitle)){
		$errors[] = "Subtitle cannot be empty.";
	}elseif(strlen($subtitle) > 200){
		$errors[] = "Subtitle cannot exceed 200 characters.";
	}
	
	// Validate content
	if(empty($content)){
		$errors[] = "Content cannot be empty.";
	}elseif(strlen($content) > 1000000){
		$errors[] = "Content too large.";
	}
	
	// Validate author 
	if(empty($author)){
		$errors[] = "Author cannot be empty.";
	}
	
	return $errors;
}

function validate_admin($connection, $id, $first_name, $last_name, $email, $username){
	$errors = [];
	
	// Validate username
	if(empty($username)){
		$errors[] = "Username cannot be empty.";
	}elseif(strlen($username) < 4){
		$errors[] = "Username must be at least 4 characters.";
	}elseif(strlen($username) > 30){
		$errors[] = "Username cannot be more than 30 characters.";
	}
	
	$existing_admin = get_admin_by_username($connection, $username);
	if(!empty($existing_admin)){
		if($existing_admin['id'] != $id){
			$errors[] = "Username taken.";
		}
	}
	
	// Validate email
	$email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
	if(empty($email)){
		$errors[] = "Email cannot be empty";
	}elseif(!preg_match($email_regex, $email)){
		$errors[] = "Invalid email format.";
	}
	
	// Validate name
	if(empty($first_name) or empty($last_name)){
		$errors[] = "Name cannot be empty.";
	}elseif(strlen($first_name > 30) or strlen($last_name) > 30){
		$errors[] = "Name cannot be greater than 30 characters.";
	}
	
	return $errors;
}

// Very basic validation functions for creating admins 
// TO DO: Add more validations to increase data reliability 
function validate_signup_info($connection, $username, $email, $password, $first_name, $last_name){
	$errors = [];
	
	// Validate username
	if(empty($username)){
		$errors[] = "Username cannot be empty.";
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
	
	// Validate name
	if(empty($first_name) or empty($last_name)){
		$errors[] = "Name cannot be empty.";
	}elseif(strlen($first_name > 30) or strlen($last_name) > 30){
		$errors[] = "Name cannot be greater than 30 characters.";
	}
	
	return $errors;
}
?>