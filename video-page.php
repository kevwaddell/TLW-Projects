<?php
/*
Template Name: Single Video page
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

<?php
$video = get_field('video');
//echo '<pre>';print_r($video);echo '</pre>';
 ?>	
		<article>
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			
			<div class="embed-container">
				<?php echo $video; ?>
			</div>
		</article>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
