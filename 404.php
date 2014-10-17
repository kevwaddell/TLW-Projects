<?php get_header(); ?>

<article <?php post_class(); ?>>
	<h2 class="text-center">Sorry! We couldn't find it.</h2>
		
		<div class="text-center">
		
			<p><strong>You have requested a page or file which does not exist.</strong></p>
			
			<p>Here are a few options to find what you are looking for.</p>
			
			<p><strong class="red-txt">1)</strong> Double check the web address for typos.<br>
			<strong class="red-txt">2)</strong> Go back to <a href="<?php echo get_option('home'); ?>" title="Home page">dashboard</a>.<br>
		
		</div>
		
</article>
		
<?php get_footer(); ?>
