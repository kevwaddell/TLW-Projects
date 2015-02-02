<?php if ( isset($_POST['edit_task']) ) { ?>

<?php 
//echo '<pre>';print_r($_POST);echo '</pre>';
$tid = $_POST['tid'];
$pid = $_POST['pid'];
global $current_user;
$users = get_users('exclude='.$current_user->ID);
$priority_level = $_POST['priority_level'];
if ($priority_level == '0') {
$priority_level = '4';
}
$task_title = trim($_POST['task_title']);
$task_date = trim($_POST['task_date']);
$task_date_convert = date('Ymd', strtotime($task_date));
$task_content = trim($_POST['task_content']);
$gdrive_link = trim($_POST['gdrive_link']);
$task_status = $_POST['task_status'];
$changes = false;
$notify = false;

$task = get_post($tid);
$project_completed_date = get_field('project_completed_date',$pid);
$task_title_orig = get_field('task_title', $task->ID);
$task_date_orig = get_field('task_date', $task->ID);
$gdrive_link_orig = get_field('gdrive_link', $task->ID);
$priority_level_orig = get_field('priority_level', $task->ID);
$task_content_orig = $task->post_content;
$task_status_orig = get_field('task_status', $task->ID);

if ($task_title !== $task_title_orig) {
$changes = true;	
}

if ($task_title == "") {
$task_title = $task_title_orig;	
}

if ($task_date_convert !== $task_date_orig) {
$changes = true;	
}

if ($task_date == "") {
$task_date_convert = $task_date_orig;	
}

if ($task_content !== $task_content_orig) {
$changes = true;	
}

if ($priority_level !== $priority_level_orig) {
$changes = true;	
}

if ($gdrive_link !== $gdrive_link_orig) {
$changes = true;	
}

if ($task_status !== $task_status_orig) {
$changes = true;
	if ($task_status == 'pending' && !empty($project_completed_date)) {
	update_post_meta($pid, 'project_completed_date', '');
	}	
}

if ($changes && $current_user->ID != $task->post_author) {
$notify = true;	
$owner = get_user_by('id', $task->post_author);
$owner_meta = get_user_meta($task->post_author, 'first_name') ;
}

if ($changes) {
	
	$task_args = array(
	'ID'	=> $tid,
	'post_content'	=> $task_content,
	'post_name' => sanitize_title($task_title.' '.$task_date_convert.' project id '.$post->ID),
	'post_title' => wp_strip_all_tags($task_title)
	);
	
	wp_update_post($task_args);
	
	update_post_meta($tid, 'task_title', $task_title); 
	update_post_meta($tid, 'task_date', $task_date_convert); 
	update_post_meta($tid, 'task_status', $task_status); 	
	update_post_meta($tid, 'gdrive_link', $gdrive_link); 
	update_post_meta($tid, 'priority_level', $priority_level); 
}
 ?>

<?php if ($changes) { ?>

<?php if ($notify) { ?>
<div class="alert alert-success">

	<h3><span><i class="fa fa-bullhorn"></i> Notify</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p>
	
	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="notify_team_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $tid; ?>" name="tid">
	<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<input type="hidden" value="edit-task" name="event-action">
	
	<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"<?php echo ($u->ID == $task->post_author) ? ' checked':''; ?>> <?php echo $u->data->display_name; ?>
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

	<h3><span><i class="fa fa-check"></i> Task updated</span></h3>

	<p class="text-center">Your task changes has been updated.</p><br>

	<div class="action-btns">
		<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>
<?php } ?>

<?php } else { ?>

<div class="alert alert-danger">
	<p class="text-center">No changes were made.</p><br>
	<div class="action-btns">
		<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>
</div>

<?php } ?>
 
<?php } ?>