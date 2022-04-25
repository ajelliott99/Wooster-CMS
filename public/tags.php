<?php 
require_once('../private/init.php');
if(!is_logged_in()){ header("Location: index.php"); } 
require_once(PRIVATE_PATH . '/database.php'); 
?>

<?php require_once(PRIVATE_PATH . '/templates/header.php'); ?>

<div class="table-container">
	<h1 class="container-header"> Tags </h1>
	<div class="create-new-button">
		<a href="<?php echo 'create.php?type=tag'; ?>">Create New Tag</a>
	</div>
	
	<table>	
	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th>ID</th>
		<th>Name</th>
		<th>Description</th>
	</tr>
	<?php
	$tags = get_all_tags($conn);
	foreach($tags as $tag){?>
		<tr>
			<td><a href="view.php?type=tag&id=<?php echo u($tag['TagID']); ?>">View</a></td>
			<td><a href="edit.php?type=tag&id=<?php echo u($tag['TagID']); ?>">Edit</a></td>
			<td><a href="delete.php?type=tag&id=<?php echo u($tag['TagID']); ?>">Delete</a></td>
			<td><?php echo h($tag['TagID']); ?></td>
			<td><?php echo h($tag['Name']); ?></td>
			<td><?php echo h($tag['Description']); ?></td>
		</tr>
	<?php } ?>
</table>
</div>

<?php require_once(PRIVATE_PATH . '/templates/footer.php'); ?>