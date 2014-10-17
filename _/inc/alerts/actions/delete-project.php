<?php if ($_GET['action'] == 'delete-project') { ?>

<?php
$pid = $_GET['pid'];

if ($_GET['tasks'] && $_GET['tasks'] > 0) {

$task_args = array(
'post_type'	=> 'tlw_task',
'post_status'	=> 'publish',
'posts_per_page' => -1,
'meta_key'	=> 'project',
'meta_value'	=> $pid
);
$tasks = get_posts($task_args);

foreach ($tasks as $t) { 
wp_trash_post( $t->ID );
}

wp_trash_post( $pid );

} else {

wp_trash_post( $pid );	
}
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

	<div class="alert alert-success">
	
		<h3><span><i class="fa fa-check"></i> Project removed</span></h3>
		
		<?php if ($_GET['tasks'] && $_GET['tasks'] > 0) { ?>
		<p class="bold text-center"><i class="fa fa-check-circle"></i> Your project has been removed.<br> And <span class="badge"><?php echo $_GET['tasks']; ?></span> tasks have been deleted.</p><br>
		<?php } else { ?>
		<p class="bold text-center"><i class="fa fa-check-circle"></i> Your project has been removed.</p><br>
		<?php } ?>

		<div class="action-btns">
			<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
		</div>

	</div>

<?php } ?>