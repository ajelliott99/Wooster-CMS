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

if($t == "post"){
	// Get post to be displayed
	$post = get_post_by_id($conn, $_GET['id']);
	// TODO: Add more robust error checking for this
	if(!$post){
		header("Location: posts.php");
	}
}elseif($t == "tag"){
	$tag = get_tag_by_id($conn, $id);
	if(!$tag){
		header("Location: posts.php");
	}
}


?>

<?php if($t == "post"){ ?>
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
<?php }elseif($t == "tag"){ ?>
	<div class="view-tag-container">
		<div class="view-tag-name-container">
			<h1><?php echo h($tag['Name']); ?></h1>
			<p><?php echo h($tag['Description']); ?></p>
		</div>
		
	</div>
	
	<div class="all-posts-container-by-tag">
	<h1 class="container-header"> Posts: <?php echo h($tag['Name']); ?></h1>

	<?php
	$posts = get_all_posts_by_tag_id($conn, $tag['TagID']);
	foreach($posts as $post){?>
	
		<div class="post-container">
			<div class="post-top-row">
				<div>
					<h3><a href="view.php?type=post&id=<?php echo h($post['PostID']); ?>"><?php echo h($post['Title']); ?></a></h3>
					<h4><?php echo h($post['Subtitle']); ?></h4>
				</div>
			</div>
			<div class="post-bottom-row">
				<?php if(is_logged_in()){ ?>
				<a href="view.php?type=post&id=<?php echo u($post['PostID']); ?>">View</a>
				<a href="edit.php?type=post&id=<?php echo u($post['PostID']); ?>">Edit</a>
				<a href="delete.php?type=post&id=<?php echo u($post['PostID']); ?>">Delete</a>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	
</div>
<?php } ?>