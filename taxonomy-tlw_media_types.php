<?php get_header(); ?>

<?php 
$projects_pg = get_page_by_title("Projects");
 ?>
 

<div class="alerts">
	
	<?php include (STYLESHEETPATH . '/_/inc/alerts/alerts.php'); ?>
			
</div>

<section class="panels">

	<?php include (STYLESHEETPATH . '/_/inc/tax/media-types/tax-projects-panel.php'); ?>

</section>

<?php get_footer(); ?>
