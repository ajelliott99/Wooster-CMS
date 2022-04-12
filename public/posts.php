<?php require_once('../private/init.php'); ?>
<?php require_once(PRIVATE_PATH . '/templates/header.php'); ?>

<div class="create-new-button">
	<a href="<?php echo 'create.php?type=post'; ?>">Create New Post</a>
</div>
<table>
	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th>ID</th>
		<th>Tag</th>
		<th>Title</th>
		<th>Subtitle</th>
	</tr>
	<?php
	$posts = get_all_posts($conn);
	foreach($posts as $post){?>
		<tr>
			<td><a href="view.php?type=post&id=<?php echo u($post['PostID']); ?>">View</a></td>
			<td><a href="edit.php?type=post&id=<?php echo u($post['PostID']); ?>">Edit</a></td>
			<td><a href="delete.php?type=post&id=<?php echo u($post['PostID']); ?>">Delete</a></td>
			<td><?php echo h($post['PostID']); ?></td>
			<td><?php echo h($post['TagID']); ?></td>
			<td><?php echo h($post['Title']); ?></td>
			<td><?php echo h($post['Subtitle']); ?></td>
		</tr>
	<?php } ?>
</table>

<?php require_once(PRIVATE_PATH . '/templates/footer.php'); ?>
