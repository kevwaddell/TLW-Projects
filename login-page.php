<?php
/*
Template Name: Login page
*/
?>

<?php get_header('user'); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
	<div class="wrapper-inner">	
		<?php the_content(); ?>
	</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer('user'); ?>
