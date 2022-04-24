<?php

session_start();

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_ROOT", dirname(PRIVATE_PATH));


// This is from a tutorial; it dynamically locates the web root, which is the public folder for this project
// Looks for the precense of "/public" in the URL, and recognizes that as the web root
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once(PRIVATE_PATH . '/database.php');
require_once(PRIVATE_PATH . "/functions.php");
require_once(PRIVATE_PATH . "/db_functions.php");
require_once(PRIVATE_PATH . "/auth_functions.php");

?>