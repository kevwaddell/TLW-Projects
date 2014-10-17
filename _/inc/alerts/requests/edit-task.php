<?php if ($_GET['request'] == 'edit-task') { ?>

<?php
$edit_task = get_post($_GET['tid']);
$task_date = get_field('task_date', $edit_task->ID);
$project = get_field('project', $edit_task->ID);
$file = get_field('gdrive_link', $edit_task->ID);
$status = get_field('task_status', $edit_task->ID);
$content = $edit_task->post_content;
//echo '<pre>';print_r($edit_task);echo '</pre>';
 ?>
<div class="alert alert-info">
	
	<h3><span><i class="fa fa-pencil"></i> Edit Task</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="edit_task_form">
	
		<input type="hidden" value="<?php echo $edit_task->ID; ?>" name="tid">
		<input type="hidden" value="<?php echo $project; ?>" name="pid">
	
		<div class="form-group">
			<label for="task_title">Task title:</label>
			<input type="text" id="task_title" name="task_title" class="form-control" value="<?php echo $edit_task->post_title ; ?>">
		</div>
		
		<div class="form-group">
			<label for="task_date">Task date</label>
			<input type="text" id="task_date" name="task_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo date('l j F, Y', strtotime($task_date)); ?>">
		</div>
		
		<div class="form-group">
			<label for="task_content">Task details</label>
			<textarea id="task_content" name="task_content" class="form-control" rows="5"><?php echo $content; ?></textarea>
		</div>

		<div class="form-group">
			<label for="gdrive_link">Link url:</label>
			<input type="text" id="gdrive_link" name="gdrive_link" class="form-control" value="<?php echo $file; ?>">
			<p class="help-block">Enter the url link for a file of web page.</p>
		</div>
		
		<div class="form-group">
		<label for="task_status">Task Status:</label>
		<label class="radio-inline">
			<input type="radio" name="task_status" id="task-status-pending" value="pending"<?php echo ($status == 'pending') ? ' checked':''; ?>> Pending
		</label>
		<label class="radio-inline">
			<input type="radio" name="task_status" id="task-status-completed" value="completed" <?php echo ($status == 'completed') ? ' checked':''; ?>> Completed
		</label>
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
					<input type="submit" name="edit_task" value="Update" class="btn btn-success btn-block">
				</div>
				<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>

		
	</form>
	
	</div>
	
</div>

<?php } ?>