<?php 
require_once('../private/init.php');
require_once(PRIVATE_PATH . '/templates/header.php');

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }
// If no ID given, redirect to homepage
if(!isset($_GET['id'])){ header("Location: index.php"); }

// If there is a type, store that as t
$t = $_GET['type'];
?>