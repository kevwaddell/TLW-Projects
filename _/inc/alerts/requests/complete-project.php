<?php if ($_GET['request'] == 'complete-project') { 
$tasks_args = array(
'post_type'	=> 'tlw_task',
'post_status'	=> 'publish',
'posts_per_page' => -1,
'meta_query' => array('relation' => 'AND',
	array('key'	=> 'project','value' => $_GET['pid']), 
	array('key'	=> 'task_status', 'value' => 'pending')
	)
);
$tasks = get_posts($tasks_args);	

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

//echo '<pre>';print_r($tasks);echo '</pre>';
?>

<?php if (empty($tasks)) { ?>

<div class="alert alert-danger">

	<h3><span><i class="fa fa-warning"></i> Alert</span></h3>

	<p class="text-center bold">Are you sure want to mark this project as completed.</p><br>

	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
			<a href="?action=complete-project&pid=<?php echo $_GET['pid']; ?>" class="btn btn-success btn-block request-btn" title="Yes"><i class="fa fa-check"></i> Yes</a>
			</div>
			<div class="col-xs-6">
			<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="No"><i class="fa fa-times"></i> No</a>
			</div>
		</div>
	</div>

</div>

<?php } else { ?>

<div class="alert alert-danger">

	<p class="text-center bold">There are still some tasks in this project that have not been completed.</p><br>

	<div class="action-btns">
	<?php if (is_single()) { ?>
		<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
	<?php } else { ?>
		<div class="row">
			<div class="col-xs-6">
			<a href="<?php echo get_permalink($_GET['pid']); ?>" class="btn btn-success btn-block" title="Yes"><i class="fa fa-eye"></i> View Tasks</a>
			</div>
			<div class="col-xs-6">
			<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel"><i class="fa fa-times"></i> Cancel</a>
			</div>
		</div>
	<?php } ?>
		
	</div>

</div>

<?php } ?>

<?php } ?>
