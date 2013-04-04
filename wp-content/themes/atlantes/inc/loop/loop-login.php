<?php wm_before_post(); ?>

<?php wm_start_post(); ?>

<div id="login">
	
<form name="loginform" id="loginform" action="<?php echo get_option('home') ?>/wp-login.php" method="post">
	<label><span><?php _e('Login') ?>:</span><input type="text" name="log" id="log" value="" size="20" tabindex="1" /></label>

	<label><span><?php _e('Senha') ?>:</span><input type="password" name="pwd" id="pwd" value="" size="20" tabindex="2" /></label>

	<p class="submit">
	<input type="submit" name="submit" id="submit" value="Login &raquo;" tabindex="3" />
	<input type="hidden" name="redirect_to" value="wp-admin/" />
	</p>

</form>
<ul>
	<li><a href="<?php echo get_option('home') ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Perdeu a senha?</a></li>
</ul>
</div>

<?php wm_end_post(); ?>