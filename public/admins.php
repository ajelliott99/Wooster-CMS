<?php 
require_once('../private/init.php');
if(!is_logged_in()){ header("Location: index.php"); } 
?>

<?php require_once(PRIVATE_PATH . '/templates/header.php'); ?>

<div class="create-new-button">
	<a href="signup.php">Create New Admin</a>
</div>

<table>
	<tr>
		<th></th>
		<th></th>
		<th>ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Username</th>
	</tr>
	<?php
	$admins = get_all_admins($conn);
	foreach($admins as $admin){?>
		<tr>
			<td><a href="edit.php?type=admin&id=<?php echo u($admin['id']); ?>">Edit</a></td>
			<td><a href="delete.php?type=admin&id=<?php echo u($admin['id']); ?>">Delete</a></td>
			<td><?php echo h($admin['id']); ?></td>
			<td><?php echo h($admin['first_name']); ?></td>
			<td><?php echo h($admin['last_name']); ?></td>
			<td><?php echo h($admin['email']); ?></td>
			<td><?php echo h($admin['username']); ?></td>
		</tr>
	<?php } ?>
</table>

<?php require_once(PRIVATE_PATH . '/templates/footer.php'); ?>