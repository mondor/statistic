<h2 class="first">Editing User</h2>

<?php echo render('users/_form'); ?>
<br />
<p>
<?php echo Html::anchor('users/view/'.$user->id, 'View'); ?> |
<?php echo Html::anchor('users', 'Back'); ?></p>
