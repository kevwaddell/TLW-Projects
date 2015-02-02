<?php if ( isset($_POST['add_task']) ) { ?>

<?php 
//echo '<pre>';print_r($projects);echo '</pre>';
global $current_user;	
$uid = $_POST['uid'];
$pid = $_POST['pid'];
$priority_level = $_POST['priority_level'];
$users = get_users();
$project = get_post($pid);
$task_title = trim($_POST['task_title']);
$task_date = trim($_POST['task_date']);
$task_date_convert = date('Ymd', strtotime($task_date));
$task_content = trim($_POST['task_content']);
$gdrive_link = trim($_POST['gdrive_link']);
$task_status = $_POST['task_status'];
$task_errors = array();
$project_completed_date = get_field('project_completed_date',$pid);
$notify = false;	

if ($task_title == "") {
$task_errors[] = "Enter a task title.";	
}

if ($uid == "0") {
$task_errors[] = "You have not selected a team member.";	
}

if ($task_date == "") {
$task_errors[] = "Please choose a task date.";	
}

if ($priority_level == 0) {
$task_errors[] = "Please choose a priority level.";	
}

if ($pid == 0) {
$task_errors[] = "Please choose a project.";	
} else {	
$project_completed_date = get_field('project_completed_date',$pid);
	if (!empty($project_completed_date) && $task_status == 'pending') {
	update_post_meta($pid, 'project_completed_date', ''); 	
	}
}

if ($current_user->ID != $project->post_author || $current_user->ID != $uid) {
$notify = true;	
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

if (empty($task_errors)) {
	
	$default_tz = date_default_timezone_get();
	date_default_timezone_set('Europe/London'); 
	
	$task_args = array(
	'post_content'	=> $task_content,
	'post_type'	=> 'tlw_task',
	'post_name' => sanitize_title('taskid '.date('Y').date('m').date('d').date('H').date('i').date('s')),
	'post_title' => wp_strip_all_tags($task_title),
	'post_author'	=> $uid,
	'post_status'	=> 'publish'
	);
	
	date_default_timezone_set($default_tz); 
	
	$tid = wp_insert_post($task_args);
	
	if ($task_status == 'pending' && !empty($project_completed_date)) {
	update_post_meta($pid, 'project_completed_date', "", $project_completed_date); 	
	}
	
	add_post_meta($tid, 'priority_level', $priority_level);
	add_post_meta($tid, 'task_title', $task_title);
	add_post_meta($tid, 'task_date', $task_date_convert);
	add_post_meta($tid, 'project', $pid);
	add_post_meta($tid, 'task_status', $task_status);	
	add_post_meta($tid, 'gdrive_link', $gdrive_link);
}
 ?>

<?php if (empty($task_errors)) { ?>

<?php if ($notify) { ?>
	
<div class="alert alert-success">

	<h3><span><i class="fa fa-bullhorn"></i> Notify</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p>
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="notify_team_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $tid; ?>" name="tid">
	<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<input type="hidden" value="add-task" name="event-action">
	
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
			<a href="<?php echo $curURL; ?>" class="btn btn-default btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
			</div>
		</div>
	</div>
	
	</form>

</div>

<?php } else { ?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-check"></i> Task Added</span></h3>

	<p class="text-center bold">Your task has been added.</p><br>

	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>

<?php } ?>

<?php } else { ?>

<div class="alert alert-danger">
		
	<h3><span><i class="fa fa-plus"></i> Add Task</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="add_task_form">
		
		<br>
		<div class="well">
			<p class="bold"><i class="fa fa-warning"></i> Errors!</p>
		
			<ul class="list-unstyled" style="margin-bottom: 0px;">
			<?php foreach ($task_errors as $error) { ?>
				<li><i class="fa fa-asterisk"></i> <?php echo $error; ?></li>
			<?php } ?>
			</ul>
		</div>

		<div class="form-group">
			<span class="label label-danger pull-right"><i class="fa fa-asterisk"></i> Required</span>
		</div>
	
		<div class="form-group required">
			<label for="task_title"><i class="fa fa-asterisk"></i> Task title:</label>
			<input type="text" id="task_title" name="task_title" class="form-control" value="<?php echo (isset($_POST['task_title'])) ? stripslashes($task_title) :''; ?>">
		</div>
		
		<?php if (isset($_GET['pid'])) { ?>
		<input type="hidden" value="<?php echo $pid; ?>" name="pid">
		<?php } else { 
		$p_args = array(
		'post_type'	=> 'tlw_project',
		'posts_per_page' => -1,
		'orderby'	=>	'title'
		);
	
		$projects = get_posts($p_args);		
		?>
		
		<div class="form-group required">
			<label for="pid"><i class="fa fa-asterisk"></i> Project:</label>
			<select name="pid" id="pid" class="form-control">
				<option value="0">Select a project</option>
				<?php foreach ($projects as $p) { ?>
				<option value="<?php echo $p->ID; ?>"<?php echo (isset($_POST['pid']) && $_POST['pid'] == $p->ID) ? ' selected':''; ?>><?php echo $p->post_title; ?></option>
				<?php } ?>
			
			</select>
		</div>
		<?php } ?>
		
		<div class="form-group required">
			<label for="uid"><i class="fa fa-asterisk"></i> Team member</label>
			<select name="uid" id="uid" class="form-control">
				<option value="0">Select a team member</option>
				<?php foreach ($users as $usr) { ?>
				<option value="<?php echo $usr->ID; ?>"<?php echo (isset($_POST['uid']) && $_POST['uid'] == $usr->ID) ? ' selected':''; ?>><?php echo $usr->data->display_name; ?></option>
				<?php } ?>
			
			</select>
		</div>
		
		<div class="form-group required">
			<label for="priority_level"><i class="fa fa-asterisk"></i> Priority Level</label>
			<select name="priority_level" id="priority_level" class="form-control">
				<option value="0">Select choose priority level</option>
				<option value="1"<?php echo ($_POST['priority_level'] == '1') ? ' selected':''; ?>>Urgent</option>
				<option value="2"<?php echo ($_POST['priority_level'] == '2') ? ' selected':''; ?>>High</option>
				<option value="3"<?php echo ($_POST['priority_level'] == '3') ? ' selected':''; ?>>Medium</option>
				<option value="4"<?php echo ($_POST['priority_level'] == '4') ? ' selected':''; ?>>Low</option>
			</select>
		</div>
		
		<div class="form-group required">
			<label for="task_date"><i class="fa fa-asterisk"></i> Task date</label>
			<input type="text" id="task_date" name="task_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo(isset($_POST['task_date'])) ? $_POST['task_date'] : date('l j F, Y', strtotime("today")) ; ?>">
		</div>
		
		<div class="form-group required">
			<label for="task_content"><i class="fa fa-asterisk"></i> Task details</label>
			<textarea id="task_content" name="task_content" class="form-control"><?php echo (isset($_POST['task_content']) && $_POST['task_content'] != '') ? stripslashes($_POST['task_content']) :''; ?></textarea>
		</div>

		<div class="form-group">
			<label for="gdrive_link">Link url:</label>
			<input type="text" id="gdrive_link" name="gdrive_link" class="form-control" value="">
			<p class="help-block">Enter the url link for a file of web page.</p>
		</div>
		
		<div class="form-group">
		<label for="task_status">Task Status:</label>
		<label class="radio-inline">
			<input type="radio" name="task_status" id="task-status-pending" value="pending" checked> Pending
		</label>
		<label class="radio-inline">
			<input type="radio" name="task_status" id="task-status-completed" value="completed"> Completed
		</label>
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-sm-6">
					<input type="submit" name="add_task" value="Update" class="btn btn-success btn-block">
				</div>
				<div class="col-sm-6">
				<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>

		
	</form>
	
	</div>
	
</div>

<?php } ?>
 
<?php } ?>