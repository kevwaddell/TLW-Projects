<?php if ( isset($_POST['add_project']) ) { ?>

<?php 
//echo '<pre>';print_r($_POST);echo '</pre>';
global $current_user;
$uid = $_POST['uid'];
$users = get_users('exclude='.$current_user->ID);
$project_title = trim($_POST['project_title']);
$project_date = trim($_POST['project_date']);
$project_date_convert = date('Ymd', strtotime($project_date));
$project_content = trim($_POST['project_content']);
$project_errors = array();
$company_tax = $_POST['company_tax'];
$media_type = $_POST['media_type'];
$companies = get_terms('tlw_company_tax', 'hide_empty=0');
$media_types = get_terms('tlw_media_types', 'hide_empty=0&parent=0');

if ($project_title == "") {
$project_errors[] = "Enter a project title.";	
}

if ($project_date == "") {
$project_errors[] = "Please choose a project start date.";	
}

if ($uid == "0") {
$project_errors[] = "You have not selected a team member.";
}

if (!isset($_POST['company_tax'])) {
$project_errors[] = "Please choose a business area.";		
}

if (!isset($_POST['media_type'])) {
$project_errors[] = "Please choose a media type.";				
}

if ($current_user->ID != $project->post_author || $current_user->ID != $uid) {
$notify = true;	
}

if (empty($project_errors)) {
	
	$default_tz = date_default_timezone_get();
	date_default_timezone_set('Europe/London'); 
	
	$project_args = array(
	'post_content'	=> $project_content,
	'post_type'	=> 'tlw_project',
	'post_name' => sanitize_title('projectid '.date('Y').date('m').date('d').date('H').date('i').date('s')),
	'post_title' => wp_strip_all_tags($project_title),
	'post_author'	=> $uid,
	'post_status'	=> 'publish'
	);
	
	date_default_timezone_set($default_tz); 
	
	$pid = wp_insert_post($project_args);
	
	wp_set_post_terms( $pid, array($company_tax), 'tlw_company_tax' );
	wp_set_post_terms( $pid, $media_type, 'tlw_media_types' );
	
	add_post_meta($pid, '_project_title', 'field_541ad2e0fc4ea');
	add_post_meta($pid, 'project_title', $project_title);
	
	add_post_meta($pid, '_project_start_date', 'field_541ad320fc4eb');
	add_post_meta($pid, 'project_start_date', $project_date_convert);
	
	add_post_meta($pid, '_project_completed_date', 'field_541bf40fadcba');
	add_post_meta($pid, 'project_completed_date', '');
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

<?php if (empty($project_errors)) { ?>

<?php if ($notify) { ?>
	
<div class="alert alert-success">

	<h3><span><i class="fa fa-bullhorn"></i> Notify</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p>
	
	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="notify_team_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<input type="hidden" value="add-project" name="event-action">
	
	<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"<?php echo ($u->ID == $project->post_author || $u->ID == $uid) ? ' checked':''; ?>> <?php echo $u->data->display_name; ?>
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

	<h3><span><i class="fa fa-check"></i> Project Added</span></h3>

	<p class="text-center bold">Your Project has been added.</p><br>

	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>

<?php } ?>

<?php } else { 	
$users = get_users();	
?>

<div class="alert alert-danger">
		
	<h3><span><i class="fa fa-plus"></i> Add Project</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="add_task_form">
		
		<br>
		<div class="well">
			<p class="bold"><i class="fa fa-warning"></i> Errors!</p>
		
			<ul class="list-unstyled" style="margin-bottom: 0px;">
			<?php foreach ($project_errors as $error) { ?>
				<li><i class="fa fa-asterisk"></i> <?php echo $error; ?></li>
			<?php } ?>
			</ul>
		</div>

		<div class="form-group">
			<span class="label label-danger pull-right"><i class="fa fa-asterisk"></i> Required</span>
		</div>
	
		<input type="hidden" value="<?php echo $uid; ?>" name="uid">
	
		<div class="form-group">
			<label for="project_title">Project title:</label>
			<input type="text" id="project_title" name="project_title" class="form-control" value="<?php echo $project_title; ?>">
		</div>
		
		<div class="form-group">
			<label for="project_date">Project date</label>
			<input type="text" id="project_date" name="project_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo $project_date; ?>">
		</div>
		
		<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"<?php echo ($u->ID == $project->post_author || $u->ID == $uid) ? ' checked':''; ?>> <?php echo $u->data->display_name; ?>
		</label>
		<?php } ?>
		</div>

		<div class="row">
		
			<div class="col-sm-6">
			
				<div class="form-group">
					<label for="project_company">Business area:</label>
					<div>
						<?php foreach ($companies as $comp) { ?>
						<label class="radio-inline">
							<input type="radio" name="company_tax" id="task-status-pending" value="<?php echo $comp->term_id ; ?>"<?php echo ($comp->term_id == $company_tax) ? ' checked':''; ?>> <?php echo $comp->name ; ?>
						</label>
						<?php } ?>
						
					</div>
				</div>

				<div class="form-group">
					<label for="project_content">Project details</label>
					<textarea id="project_content" name="project_content" class="form-control" rows="6"><?php echo $project_content; ?></textarea>
				</div>
				
			</div>
			
			<div class="col-sm-6">
								
				<div class="form-group">
					<label for="project_company">Media type:</label>
		
					<?php foreach ($media_types as $media) { 
					$media_kids = get_terms('tlw_media_types', 'hide_empty=0&parent='.$media->term_id);
					?>
						
					<div class="checkbox">
						<label>
							<input type="checkbox" name="media_type[]" value="<?php echo $media->term_id; ?>"<?php echo (in_array($media->term_id, $media_type)) ? ' checked':''; ?>> <?php echo $media->name; ?>
						</label>
						<?php if ($media_kids) { ?>
							<?php foreach ($media_kids as $mk) { ?>
							<div class="checkbox indented">
								<label>
								<input type="checkbox" name="media_type[]" value="<?php echo $mk->term_id; ?>"<?php echo (in_array($mk->term_id, $media_type)) ? ' checked':''; ?>> <?php echo $mk->name; ?>
								</label>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
					<?php } ?>
				
				</div>
				
			</div>
			
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
					<input type="submit" name="add_project" value="Add" class="btn btn-success btn-block">
				</div>
				<div class="col-xs-6">
				<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>
		
	</form>
	
	</div>
	
</div>

<?php } ?>
 
<?php } ?>