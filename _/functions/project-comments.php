<?php function projects_comment($comment, $args, $depth) {

   $GLOBALS['comment'] = $comment; ?>
<div <?php comment_class('list-group-item'); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>">
	
		 <div class="row">
			 
			 <div class="col-xs-3 col-sm-2 col-lg-1">
				<div class="comment-author vcard">
					 <?php echo get_avatar($comment,$size='48' ); ?>
				</div>
			</div>
			
			<div class="col-xs-9 col-sm-10 col-lg-11">
			
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.') ?></em>
				<br />
				<?php endif; ?>
				
				<div class="comment-meta commentmetadata">
					<h4 class="label label-default"><i class="fa fa-comment"></i> <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?><h4>
					<time><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></time>
				</div>
				
				<?php comment_text() ?>
				
			</div>
		
		</div><!-- End row -->
	
	</div>

</div>
     
<?php } ?>