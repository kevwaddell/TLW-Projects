<?php
global $post;
if ( post_password_required() ) {
	return;
}
?>
<?php if ( have_comments() ) : ?>
<div id="comments" class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title text-center">Comments</h3>
	</div>
	
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<ul class="pager">
		<li><?php previous_comments_link( __( '<i class="fa fa-angle-left"></i> Older', 'tlwprojects' ) ); ?></li>
		<li><?php next_comments_link( __( 'Newer <i class="fa fa-angle-right"></i>', 'tlwprojects' ) ); ?></li>
	</ul><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<div class="list-group">
	<?php
	//$comments = get_comments('post_id='.$post->ID);
	//echo '<pre>';print_r($comments);echo '</pre>';
	?>
		<?php
			wp_list_comments( array(
				'avatar_size'=> 65,
				'callback' => 'projects_comment'
			) );
		?>
	</div><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<ul class="pager">
		<li><?php previous_comments_link( __( '<i class="fa fa-angle-left"></i> Older', 'tlwprojects' ) ); ?></li>
		<li><?php next_comments_link( __( 'Newer <i class="fa fa-angle-right"></i>', 'tlwprojects' ) ); ?></li>
	</ul><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	 <div class="panel-body">
		 <p class="no-comments"><?php _e( 'Comments are closed.', 'tlwprojects' ); ?></p>
	 </div>
	<?php endif; ?>

</div><!-- #comments -->

<?php endif; // have_comments() ?>

<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title text-center"><?php comment_form_title( 'Leave a Comment', 'Leave a Comment for %s' ); ?></h3>
	</div>
	<div class="panel-body">
	<?php 
	$defaults = array(
    'comment_field'        => '<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea class="form-control" id="comment" name="comment" rows="5" aria-required="true"></textarea></div>',
    'comment_notes_after'  => '',
    'title_reply'          => "",
    'title_reply_to'       => "",
    'cancel_reply_link'    => __( 'Cancel comment' ),
    'label_submit'         => __( 'Post comment' ),
	);
	
	comment_form($defaults); 
	?>
	</div>
	
</div><!-- #comments -->
