<?php
/*
Template Name: Guide single page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 

$child_args = array(
'parent'	=> $post->post_parent,
'sort_column'	=> 'menu_order'
);
$children = get_pages($child_args);

$grandchild_args = array(
'parent'	=> get_the_ID(),
'sort_column'	=> 'menu_order'
);
$grand_children = get_pages($grandchild_args);

$parent = get_post($post->post_parent);
$parent_icon = get_field('page_icon', $post->post_parent);
//echo '<pre>';print_r($parent);echo '</pre>';
 ?>	
	<div class="row">
		<div class="col-md-8">
		
		<article <?php post_class(); ?>>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center"><?php the_title(); ?></h3>
				</div>
				<div class="panel-body">
					<?php if (has_post_thumbnail()) { 
					$img_atts = array('class'	=> "img-responsive");
					$lg_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
					//echo '<pre>';print_r($lg_img);echo '</pre>';
					?>
					<div class="feat-img">
					<?php the_post_thumbnail( 'large', $img_atts ); ?>
					<a href="<?php echo $lg_img[0]; ?>" class="btn btn-default zoom-btn" rel="fancy-box"><i class="fa fa-search fa-lg"></i></a>
					</div>
					<?php }  ?>
					
					<?php the_content(); ?>			
				</div>
			</div>
		
		</article>
		
		</div>
		
		<div class="col-md-4">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center"><?php echo $parent->post_title; ?></h3>
				</div>
				<div class="panel-body">
					<ul class="list-group">
						<a href="<?php echo get_permalink($parent->ID); ?>" class="list-group-item text-center float-icon">
							<i class="fa <?php echo $parent_icon; ?> fa-lg"></i> 
							<?php echo $parent->post_title; ?>
						</a>
						
						<?php foreach ($children as $child) { 
						$icon = get_field('page_icon', $child->ID);
						?>
						<a href="<?php echo get_permalink($child->ID); ?>" class="list-group-item text-center float-icon <?php echo (get_the_ID() == $child->ID) ? ' active':''; ?>">
							<i class="fa <?php echo $icon; ?> fa-lg"></i>
							<?php echo $child->post_title; ?>
						</a>
						<?php } ?>
					</ul>
				</div>
				
			</div>
				
			<?php if ($grand_children) { ?>
				
			<div class="panel panel-default">
				
				<div class="panel-heading">
					<h3 class="panel-title text-center"><?php the_title(); ?></h3>
				</div>
				
				<div class="panel-body">
					<ul class="list-group">
						
						<?php foreach ($grand_children as $gchild) { 
						$icon = get_field('page_icon', $gchild->ID);
						?>
						<a href="<?php echo get_permalink($gchild->ID); ?>" class="list-group-item text-center float-icon">
							<i class="fa <?php echo $icon; ?> fa-lg"></i>
							<?php echo $gchild->post_title; ?>
						</a>
						<?php } ?>
					</ul>
				</div>
				
			</div>
			
			<?php } ?>

		</div>
		
	</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
