<?php echo Form::open(); ?>
	<p>
		<?php echo Form::label('Username', 'username'); ?>
<?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : '')); ?>
	</p>
	<p>
		<?php echo Form::label('Password', 'password'); ?>
<?php echo Form::input('password', Input::post('password', isset($user) ? $user->password : '')); ?>
	</p>
	<p>
		<?php echo Form::label('Email', 'email'); ?>
<?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : '')); ?>
	</p>
	<p>
		<?php echo Form::label('Last login', 'last_login'); ?>
<?php echo Form::input('last_login', Input::post('last_login', isset($user) ? $user->last_login : '')); ?>
	</p>

	<div class="actions">
		<?php echo Form::submit(); ?>	</div>

<?php echo Form::close(); ?>