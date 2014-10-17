<?php if ($_GET['request'] == 'delete-project') { ?>

<?php
$pid = $_GET['pid'];
$project = get_post($pid);
global $current_user;
$owner = get_userdata($project->post_author);	

$task_args = array(
'post_type'	=> 'tlw_task',
'post_status'	=> 'publish',
'posts_per_page' => -1
);

$task_args['meta_query'] = array( 'relation' => 'AND', array('key'	=> 'project','value'	=> $pid), array('key'	=> 'task_status','value'	=> 'pending')) ;
$pending_tasks = get_posts($task_args);

$task_args['meta_query'] = array( 'relation' => 'AND', array('key'	=> 'project','value'	=> $pid)) ;

$tasks = get_posts($task_args);

$curURL = get_permalink();

if (is_front_page()) {
$curURL = get_option('home');
}

if (is_tax('tlw_media_types')) {
$media_type = get_query_var("media-type");
$curURL = get_term_link($media_type, 'tlw_media_types');
}

if (is_tax('tlw_company_tax')) {
$company = get_query_var("company");
$curURL = get_term_link($company, 'tlw_company_tax');
}

if (is_post_type_archive('tlw_project')) {
$projects_pg = get_page_by_title('Projects');
$curURL = get_permalink($projects_pg->ID);
}
?>
 
 <?php if ($current_user->ID == $project->post_author) { ?>

 	
	<div class="alert alert-danger">
	
		<h3><span><i class="fa fa-warning"></i> Alert</span></h3>
		 
		 <?php if ($pending_tasks) { ?>
		<p class="text-center">There is <span class="badge"><?php echo count($pending_tasks); ?></span> pending tasks for this project.
		<br>Are you sure you want to delete this project.
		</p><br>
		
		<?php } else { ?>
		<p class="bold text-center"><i class="fa fa-warning"></i> Are you sure want to remove this project.</p><br>
		<?php } ?>

		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
				<a href="?action=delete-project&pid=<?php echo $pid; ?><?php echo ($tasks) ? '&tasks='.count($tasks):''; ?>" class="btn btn-success btn-block request-btn" title="Yes"><i class="fa fa-check"></i> Yes</a>
				</div>
				<div class="col-xs-6">
				<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="No"><i class="fa fa-times"></i> No</a>
				</div>
			</div>
		</div>

	</div>
 
 <?php } else { ?>
 	
	<div class="alert alert-danger">
	
		<h3><span><i class="fa fa-warning"></i> Alert</span></h3>
		
		<p class="text-center">Sorry this project was created by <strong><?php echo $owner->data->display_name; ?></strong>.<br> You do not have permission to remove this project.</p><br>

		<div class="action-btns">
			<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
		</div>

	</div>
 
 <?php } ?>

<?php } ?>