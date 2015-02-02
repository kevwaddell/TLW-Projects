<?php if ($_GET['request'] == 'add-task') { ?>

<?php
$pid = $_GET['pid'];
global $current_user;
$users = get_users();

if (isset($_GET['pid'])) {
	$pid = $_GET['pid'];
} else {
	$p_args = array(
	'post_type'	=> 'tlw_project',
	'posts_per_page' => -1,
	'orderby'	=>	'title'
	);
	
	$projects = get_posts($p_args);	
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

//echo '<pre>';print_r($edit_task);echo '</pre>';
 ?>
<div class="alert alert-info">
	
	<h3><span><i class="fa fa-plus"></i> Add Task</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="add_task_form">
	
		<div class="form-group">
			<span class="label label-danger pull-right"><i class="fa fa-asterisk"></i> Required</span>
		</div>
			
		<div class="form-group required">
			<label for="task_title"><i class="fa fa-asterisk"></i> Task title:</label>
			<input type="text" id="task_title" name="task_title" class="form-control" value="">
		</div>
		
		<?php if (isset($_GET['pid'])) { ?>
		<input type="hidden" value="<?php echo $pid; ?>" name="pid">
		<?php } else { ?>
		
		<div class="form-group required">
			<label for="pid"><i class="fa fa-asterisk"></i> Project:</label>
			<select name="pid" id="pid" class="form-control">
				<option value="0">Select a project</option>
				<?php foreach ($projects as $p) { ?>
				<option value="<?php echo $p->ID; ?>"><?php echo $p->post_title; ?></option>
				<?php } ?>
			
			</select>
		</div>
		<?php } ?>
		
		<div class="form-group required">
			<label for="uid"><i class="fa fa-asterisk"></i> Team member</label>
			<select name="uid" id="uid" class="form-control">
				<option value="0">Select a team member</option>
				<?php foreach ($users as $usr) { ?>
				<option value="<?php echo $usr->ID; ?>"<?php echo ($usr->ID == $current_user->ID) ? ' selected':''; ?>><?php echo $usr->data->display_name; ?></option>
				<?php } ?>
			
			</select>
		</div>
		
		<div class="form-group required">
			<label for="priority_level"><i class="fa fa-asterisk"></i> Priority Level</label>
			<select name="priority_level" id="priority_level" class="form-control">
				<option value="0">Select choose priority level</option>
				<option value="1">Urgent</option>
				<option value="2">High</option>
				<option value="3">Medium</option>
				<option value="4">Low</option>
			</select>
		</div>
		
		<div class="form-group required">
			<label for="task_date"><i class="fa fa-asterisk"></i> Task date</label>
			<input type="text" id="task_date" name="task_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo date('l j F, Y', strtotime("today")); ?>">
		</div>
		
		<div class="form-group">
			<label for="task_content">Task details</label>
			<textarea id="task_content" name="task_content" class="form-control" rows="5"></textarea>
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
				<div class="col-xs-6">
					<input type="submit" name="add_task" value="Add" class="btn btn-success btn-block">
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