<?php if ($_GET['action'] == 'completed') { 
$tid = $_GET['tid'];
$pid = $_GET['pid'];
$task = get_post($tid);
$task_status = $_GET['action'];
$project = get_post($pid);
update_post_meta($tid, 'task_status', $task_status);	
global $current_user;
$users = get_users('exclude='.$current_user->ID);	
//echo '<pre>';print_r($users);echo '</pre>';
?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-check"></i> Task Completed</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p>
	
	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="notify_task_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php echo $tid; ?>" name="tid">
	<input type="hidden" value="completed-task" name="event-action">
	
	<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"<?php echo ($u->ID == $project->post_author || $u->ID == $task->post_author) ? ' checked':''; ?>> <?php echo $u->data->display_name; ?>
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

<?php } ?>