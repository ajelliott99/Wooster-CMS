<?php 
require_once('../private/init.php');
if(!is_logged_in()){ header("Location: index.php"); }  
require_once(PRIVATE_PATH . '/templates/header.php'); 
?>

<div class="all-posts-container">
	<h1 class="container-header"> Posts </h1>
	<p class="container-subhead"> sorted by most recent updates </p>
	<?php if(is_logged_in()){ ?>
	<div class="create-new-button">
		<a href="<?php echo 'create.php?type=post'; ?>">Create New Post</a>
	</div>
	<?php } ?>

	<?php
	$posts = get_all_posts($conn);
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

<?php //require_once(PRIVATE_PATH . '/templates/footer.php'); ?>
