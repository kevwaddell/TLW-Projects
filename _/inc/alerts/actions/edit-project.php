<?php if ( isset($_POST['edit_project']) ) { ?>

<?php 
//echo '<pre>';print_r($_POST);echo '</pre>';
$pid = $_POST['pid'];
global $current_user;
$users = get_users('exclude='.$current_user->ID);
$project = get_post($pid);
$project_title = trim($_POST['project_title']);
$project_date = trim($_POST['project_date']);
$project_date_convert = date('Ymd', strtotime($project_date));
$project_content = trim($_POST['project_content']);
$company_tax = $_POST['company_tax'];
$media_type = $_POST['media_type'];
$changes = false;

$project_title_orig = get_field('project_title', $pid);
$project_date_orig = get_field('project_start_date', $pid);
$project_content_orig = $project->post_content;
$project_company_orig = wp_get_post_terms($pid, 'tlw_company_tax', array("fields" => "ids"));
$project_media_orig = wp_get_post_terms($pid, 'tlw_media_types', array("fields" => "ids"));
$media_diff = array_intersect($project_media_orig, $media_type);

if ( $project_title !== $project_title_orig) {
$changes = true;	
} 

if ($project_date_convert !== $project_date_orig) {
$changes = true;	
} 

if ($project_content !== $project_content_orig) {	
$changes = true;		
}

if ($project_content !== $project_content_orig) {	
$changes = true;		
}

if ( !in_array($company_tax, $project_company_orig) ) {	
$changes = true;		
}

if (!empty($media_diff)) {
$changes = true;
}

if ($project_title == "") {
$project_title = $project_title_orig;	
}

if ($project_date == "") {
$project_date_convert = $project_date_orig;	
}

if ($changes && $current_user->ID != $task->post_author) {
$notify = true;	
$owner = get_user_by('id', $project->post_author);
$owner_meta = get_user_meta($project->post_author, 'first_name') ;
}

if ($changes) {
	
	$project_args = array(
	'ID'	=> $pid,
	'post_content'	=> $project_content,
	'post_title' => wp_strip_all_tags($project_title)
	);
	
	wp_update_post($project_args);
	wp_set_post_terms( $pid, array($company_tax), 'tlw_company_tax' );
	wp_set_post_terms( $pid, $media_type, 'tlw_media_types' );
	
	update_post_meta($pid, 'project_title', $project_title); 
	update_post_meta($pid, 'project_start_date', $project_date_convert); 
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

<?php if ($changes) { ?>

<?php if ($notify) { ?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-bullhorn"></i> Notify</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p>
	
	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="notify_team_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<input type="hidden" value="edit-project" name="event-action">
	
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
			<a href="<?php the_permalink(); ?>" class="btn btn-default btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
			</div>
		</div>
	</div>
	
	</form>

</div>

<?php } else { ?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-check"></i> Project Updated</span></h3>

	<p class="text-center">Your project changes have been updated.</p><br>

	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>
<?php } ?>

<?php } else { ?>

<div class="alert alert-danger">
	<p class="text-center">No changes were made.</p><br>
	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>
</div>

<?php } ?>
 
<?php } ?>