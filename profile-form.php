<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><?php the_title(); ?></h3>
	</div>
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post">
	
	<div class="panel-body">
		
			<div class="col-sm-9 col-md-10">
				<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
				<input type="hidden" name="from" value="profile" />
				<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		
				<?php do_action( 'profile_personal_options', $profileuser ); ?>
				
				<div class="form-group form-group-lg">
					<label for="first_name" class="control-label"><?php _e( 'First Name' ); ?></label>
					<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="form-control" />
				</div>
				
				<div class="form-group form-group-lg">
					<label for="first_name" class="control-label"><?php _e( 'Last Name' ); ?></label>
					<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="form-control" />
				</div>
				
				<div class="form-group form-group-lg">
					<label for="email" class="control-label"><?php _e( 'E-mail' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label>
					<input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="form-control" />
				</div>
				
				<?php
				$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
				if ( $show_password_fields ) :
				?>
				
				<div class="form-group form-group-lg">
					<label for="pass1" class="control-label"><?php _e( 'New Password' ); ?></label>
						<input type="password" name="pass1" id="pass1" size="16" value="" class="form-control" autocomplete="off" /> 
						<span class="help-block"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.' ); ?></span>
						<input type="password" name="pass2" id="pass2" size="16" value="" class="form-control" autocomplete="off" />
						<span class="help-block"><?php _e( 'Type your new password again.' ); ?></span>
						<div id="pass-strength-result" class="block"><?php _e( 'Strength indicator', 'theme-my-login' ); ?></div>
						<span class="help-block"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).' ); ?></span>
				</div>
				<?php endif; ?>
			
			</div><!-- col -->
			
			<div class="col-sm-3 col-md-2 hidden-xs">
			 <div class="avatar"><?php echo get_avatar( $current_user->ID, 200 ); ?></div>     
			</div>

		</div><!-- Panel body -->
		
		<div class="panel-footer" style="padding-left: 30px;">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary btn btn-success" value="<?php esc_attr_e( 'Update Profile' ); ?>" name="submit" />
		</div>
	
	</form>
</div>
