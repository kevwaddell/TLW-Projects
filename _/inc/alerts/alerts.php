<?php if (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST' ) { ?>
<div class="actions-wrap">
	
	<div class="actions-wrap-inner">
		<!-- PROJECT REQUESTS -->
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/edit-project.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/complete-project.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/delete-project.php'); ?>
		
		<?php if (!is_single()) { ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/add-project.php'); ?>
		<?php } ?>
		
		<!-- PROJECT ACTIONS -->
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/edit-project.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/complete-project.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/delete-project.php'); ?>
		
		<?php if (!is_single()) { ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/add-project.php'); ?>
		<?php } ?>
		
		
		<!-- TASK REQUESTS -->
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/add-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/add-link.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/edit-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/delete-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/requests/complete-task.php'); ?>
		
		<!-- TASK ACTIONS -->
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/add-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/add-link.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/edit-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/delete-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/complete-task.php'); ?>
		<?php include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-team.php'); ?>
		
		
	</div>

</div>
<?php } ?>
