<?php
/*
Template Name: Guides page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('page_icon', $child->ID);
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
			
				<div class="panel-group" id="accordion">
					<?php foreach ($children as $child) { 
					$icon = get_field('page_icon', $child->ID);
					$kids = get_pages('sort_column=menu_order&parent='.$child->ID);
					?>
					<div class="panel panel-default">
						<div class="panel-heading lite">
						<a data-toggle="collapse" data-parent="#accordion" class="btn btn-primary btn-lg btn-block float-icon text-center" href="#collapse-<?php echo $child->post_name; ?>"><i class="fa <?php echo $icon; ?> fa-lg"></i> <?php echo $child->post_title; ?></a>
						</div>
						<div id="collapse-<?php echo $child->post_name; ?>" class="panel-collapse collapse">
							<div class="panel-body">
							<div class="btn-group-vertical block">
									<a href="<?php echo get_permalink($child->ID); ?>" class="btn btn-primary btn-block float-icon"><i class="fa fa-info-circle fa-lg"></i>
									<?php if ($child->post_name != 'getting-started') { ?>
									About 
									<?php } ?>
									<?php echo $child->post_title; ?>
									</a>
									<?php foreach ($kids as $kid) { 
									$icon = get_field('page_icon', $kid->ID);	
									?>
									<a href="<?php echo get_permalink($kid->ID); ?>" class="btn btn-primary btn-block float-icon"><i class="fa <?php echo $icon; ?> fa-lg"></i><?php echo $kid->post_title; ?></a>
									<?php } ?>
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
