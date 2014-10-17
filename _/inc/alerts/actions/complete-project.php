<?php if ($_GET['action'] == 'complete-project') { 
$pid = $_GET['pid'];
$project_completed_date = date('Ymd', strtotime("now"));
$project = get_post($pid);
//echo '<pre>';print_r($project_completed_date);echo '</pre>';
update_post_meta($pid, 'project_completed_date', $project_completed_date);	
global $current_user;
$users = get_users('exclude='.$current_user->ID);	
//echo '<pre>';print_r($users);echo '</pre>';

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

	<h3><span><i class="fa fa-check"></i> Project Completed</span></h3>

	<p class="text-center"><strong>Your project has been marked as completed.</strong><br>
		Would you like to notify team members.<br><br>
	</p>
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="notify_task_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<input type="hidden" value="completed-project" name="event-action">
	
	<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"<?php echo ($u->ID == $project->post_author) ? ' checked':''; ?>> <?php echo $u->data->display_name; ?>
		</label>
		<?php } ?>
	</div>

	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
			<input type="submit" name="notify-team" value="Notify" class="btn btn-success btn-block">
			</div>
			<div class="col-xs-6">
			<a href="<?php echo $curURL; ?>" class="btn btn-default btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
			</div>
		</div>
	</div>
	
	</form>

</div>

<?php } ?>