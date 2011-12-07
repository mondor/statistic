<div id="login" class="clearfix">
 
 <?php if(count($errors)) echo implode(",", $errors);  ?>
 
<?php echo Form::open("user/login"); ?>
<div class="fields">
 <div class="field_name">Username</div>
 <div class="field_value"><?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : '')); ?></div>
</div>
 
 
<div class="fields">
 <div class="field_name">Password</div> 
 <div class="field_value"><input type="password" name="password" value="<?php echo isset($user) ? $user->password : ''; ?>" /></div>
</div>

<div class="search-button">
<input id="form_login" type="submit" value="Login" name="login" style="float:right"/>	
</div>

<?php echo Form::close(); ?>

</div>