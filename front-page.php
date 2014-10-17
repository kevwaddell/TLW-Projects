<?php get_header(); ?>

<div class="alerts">
	
	<?php include (STYLESHEETPATH . '/_/inc/alerts/alerts.php'); ?>
			
</div>

<section class="dashboard-panels">

	<?php include (STYLESHEETPATH . '/_/inc/dashboard/overview-panel.php'); ?>

	<?php include (STYLESHEETPATH . '/_/inc/dashboard/projects-panel.php'); ?>
		
	<?php include (STYLESHEETPATH . '/_/inc/dashboard/tasks-panel.php'); ?>

</section>

<?php get_footer(); ?>
