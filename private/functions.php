<?php
function h($string){
	return htmlspecialchars($string);
}

function u($url){
	return urlencode($url);
}

function db_escape($connection, $query){
	return mysqli_real_escape_string($connection, $query);
}

function display_errors($errors){
	$html = "
	<div class='errors-box'>
	<ul>";
		
	foreach($errors as $error){
		$html .= "<li>" . $error . "</li>";
	}
		
	$html .= "
	</ul>
	</div>
	";
	
	return $html;
}
?>