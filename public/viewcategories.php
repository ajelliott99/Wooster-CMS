<?php 
require_once('../private/init.php');
require_once(PRIVATE_PATH . '/templates/header.php');

$tags = get_all_tags($conn);

?>

<div class="all-tags-container">
	<h1 class="tags-container-header"> View posts by category </h1>

	<?php
	foreach($tags as $tag){?>
		<div class="tag-container">
			<div class="tag-top-row">
				<div>
				
					<h3><a class="view-post-btn" href="view.php?type=tag&id=<?php echo $tag['TagID']; ?>"><?php echo h($tag['Name']); ?></a></h3>
					<h4><?php echo h($tag['Description']); ?></h4>
				</div>
			</div>
			<div class="tag-bottom-row">
				<a class="view-post-btn" href="view.php?type=tag&id=<?php echo $tag['TagID']; ?>">View Posts</a>
				<?php if(is_logged_in()){ ?>
				</br>
				<a href="view.php?type=tag&id=<?php echo u($tag['TagID']); ?>">View</a>
				<a href="edit.php?type=tag&id=<?php echo u($tag['TagID']); ?>">Edit</a>
				<a href="delete.php?type=tag&id=<?php echo u($tag['TagID']); ?>">Delete</a>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	
</div>