<?php
/*
Template Name: Videos page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('page_icon');
$child_args = array(
'parent'	=> get_the_ID(),
'sort_column'	=> 'menu_order'
);
$children = get_pages($child_args);
//echo '<pre>';print_r($children);echo '</pre>';
 ?>	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center"><?php the_title(); ?></h3>
			</div>
			<div class="panel-body">
			<span class="fa <?php echo $icon; ?> fa-4x block icon"></span>
			<?php the_content(); ?>	
			
				<div class="row">
					<?php foreach ($children as $child) { 
					$icon = get_field('page_icon', $child->ID);
					$video = get_field('video', $child->ID);
					$video_tn = get_field('video_thumb', $child->ID);
					//echo '<pre>';print_r($video_tn['sizes']['video-thumb']);echo '</pre>';
					?>
						<div class="col-sm-6 col-md-4">
							<div class="well well-sm">
								<div class="video-thumb">
									<img src="<?php echo $video_tn['sizes']['video-thumb']; ?>" class="img-responsive">
								</div>
								<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-<?php echo $child->post_name; ?>"><?php echo $child->post_title; ?></button>
							</div>
							<!-- Large modal -->
	
							<div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-<?php echo $child->post_name; ?>" role="dialog" aria-labelledby="modal-<?php echo $child->post_name; ?>" aria-hidden="true">
							  <div class="modal-dialog modal-lg">
							    <div class="modal-content">
							     <div class="modal-header">
							     	 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel"><?php echo $child->post_title; ?></h4>
								  </div>
							     <div class="modal-body">
							    	
							    	<div class="embed-container">
									 <?php echo $video; ?>
									</div>
									 
							     </div>
							    </div>
							  </div>
							</div>
						</div>
					<?php } ?>

				</div>		
			</div>
		</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
