<h2 class="first">Listing Users</h2>

<?php if ($users): ?>
<table cellspacing="0">
	<tr>
		<th>Username</th>
		<th>Password</th>
		<th>Email</th>
		<th>Last login</th>
		<th></th>
	</tr>

	<?php foreach ($users as $user): ?>	<tr>

		<td><?php echo $user->username; ?></td>
		<td><?php echo $user->password; ?></td>
		<td><?php echo $user->email; ?></td>
		<td><?php echo $user->last_login; ?></td>
		<td>
			<?php echo Html::anchor('users/view/'.$user->id, 'View'); ?> |
			<?php echo Html::anchor('users/edit/'.$user->id, 'Edit'); ?> |
			<?php echo Html::anchor('users/delete/'.$user->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>		</td>
	</tr>
	<?php endforeach; ?></table>

<?php else: ?>
<p>No Entries.</p>

<?php endif; ?>
<br />

<?php echo Html::anchor('users/create', 'Add new User'); ?>