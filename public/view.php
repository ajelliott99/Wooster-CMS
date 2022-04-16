<?php 
require_once('../private/init.php');
require_once(PRIVATE_PATH . '/templates/header.php');

// If there is no type in the URL, redirect to homepage
if(!isset($_GET['type'])){ header("Location: index.php"); }
// If no ID given, redirect to homepage
if(!isset($_GET['id'])){ header("Location: index.php"); }

// If there is a type, store that as t
$t = $_GET['type'];
$id = $_GET['id'];

// Get post to be displayed
$post = get_post_by_id($conn, $_GET['id']);
// TODO: Add more robust error checking for this
if(!$post){
	header("Location: posts.php");
}
?>

<div class="view-post-container">
	<div class="view-post-title-container">
		<h1><?php echo h($post['Title']); ?></h1>
		<h2><?php echo h($post['Subtitle']); ?></h2>
		<p class="view-post-author"> By: <?php echo h($post['Author']); ?> </p>
	</div>
	<div class="view-post-content-container">
		<p>
			<?php echo h($post['Content']); ?>
		</p>
	</div>
</div>