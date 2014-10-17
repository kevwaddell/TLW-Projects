<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<h1>Lost your password</h1>
	<?php $template->the_action_template_message( 'lostpassword' ); ?>
	<?php $template->the_errors(); ?>
	<form name="lostpasswordform" id="lostpasswordform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'lostpassword' ); ?>" autocomplete="off" method="post">
		<div class="form-group">
			<div class="input-group">
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" placeholder="Username or E-mail" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
			<span class="input-group-btn">
				<button type="submit" name="wp-submit" class="btn btn-default" id="wp-submit<?php $template->the_instance(); ?>"><i class="fa fa-angle-right fa-lg"></i></button>
			</span>
			</div>
		</div>

		<?php do_action( 'lostpassword_form' ); ?>

		<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'lostpassword' ); ?>" />
		<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
		<input type="hidden" name="action" value="lostpassword" />
	</form>
	
</div>

<footer class="user-footer"><?php $template->the_action_links( array( 'lostpassword' => false ) ); ?></footer>