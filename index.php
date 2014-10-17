<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>		
		<article>
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
		</article>
<?php endwhile; ?>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>

<?php get_footer(); ?>
