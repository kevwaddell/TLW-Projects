<div id="tasks-list" class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title text-center">Tasks</h3>
	</div>
		
	<div id="tasks-wrap" class="content-wrap">
		<div class="content-inner">
		
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-6">
				<div class="btn-group filter-actions">
					<?php if ($pending_total == 0 && $completed_total > 0) { ?>
					<a href="?tasks-filter=complete" class="btn btn-success<?php echo ($_GET['tasks-filter'] == 'complete' || !isset($_GET['tasks-filter']))? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete <span class="label label-success"><?php echo $completed_total; ?></span></a>
					<a href="?tasks-filter=pending" class="btn btn-danger<?php echo ($_GET['tasks-filter'] == 'pending')? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending <span class="label label-danger"><?php echo $pending_total; ?></span></a>
					<?php } else { ?>
					<a href="?tasks-filter=pending" class="btn btn-danger<?php echo ($_GET['tasks-filter'] == 'pending' || !isset($_GET['tasks-filter']))? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending <span class="label label-danger"><?php echo $pending_total; ?></span></a>
					<a href="?tasks-filter=complete" class="btn btn-success<?php echo ($_GET['tasks-filter'] == 'complete')? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete <span class="label label-success"><?php echo $completed_total; ?></span></a>
		
					<?php } ?>
				</div>
			</div>
			<div class="col-xs-6 text-right">
				<a href="?request=add-task&pid=<?php echo $post->ID; ?>" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Task</span></a>
			</div>
		</div>
	</div>
		
<?php if ($tasks) { ?>

	
	<div class="list-group">
		
		<?php foreach ($tasks as $t) { 
		$title = $t->post_title;
		$content = apply_filters('the_content', $t->post_content );
		$owner = get_userdata($t->post_author);	
		$status = get_field('task_status', $t->ID);
		$task_date = get_field('task_date', $t->ID);
		$download = get_field('gdrive_link', $t->ID);
		$project_id = get_field('project', $t->ID);
		//echo '<pre>';print_r($owner);echo '</pre>';
		?>
		<div class="list-group-item list-group-item-<?php echo ($status == 'completed') ? 'success':'danger'; ?>">
			<?php if ($status == 'pending') { ?>
			<span class="fa fa-clock-o fa-2x"></span>
			<?php } else  { ?>
			<span class="fa fa-check fa-2x"></span>
			<?php } ?>
			<div class="row">
				
				<div class="col-xs-10 col-md-11">
					<span class="label label-default task-label date"><i class="fa fa-calendar"></i> <?php echo date('D jS M, Y', strtotime($task_date)); ?></span> 
					<span class="label label-default task-label name"><i class="fa fa-user"></i> <?php echo $owner->data->display_name; ?></span> 
					<h4 class="list-group-item-heading"><?php echo $title; ?></h4>
					<div class="list-group-item-text"><?php echo $content; ?></div>
				</div>
				
				<div class="col-xs-2 col-md-1">
				
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-<?php echo ($status == 'completed') ? 'success':'danger'; ?> dropdown-toggle" data-toggle="dropdown">
						 <i class="fa fa-cogs fa-lg"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php if ($status == 'pending') { ?>
							<li><a href="?request=completed&tid=<?php echo $t->ID; ?>&pid=<?php echo $project_id; ?>" class="request-btn"><i class="fa fa-check"></i> Complete Task</a></li>
							<?php } ?>
							<li><a href="?request=edit-task&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>" class="request-btn"><i class="fa fa-pencil"></i> Edit Task</a></li>
							<li><a href="?request=delete-task&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>" class="request-btn"><i class="fa fa-trash"></i> Delete Task</a></li>
							<?php if ($download) { ?>
							<li><a href="<?php echo $download; ?>" target="_blank"><i class="fa fa-link"></i> View Link</a></li>
							<?php } else { ?>
							<li><a href="?request=add-link&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>" class="request-btn"><i class="fa fa-link"></i> Add Link</a></li>
							<?php } ?>
						</ul>
					</div>
					
				</div>
				
			</div>
			
		</div>
		<?php } ?>
				
	</div>

<?php } else { ?>
	<div class="panel-body text-center">
		<span class="fa fa-list fa-4x block icon"></span>
		<?php 
		if ( $_GET['tasks-filter'] == 'complete' ) {
		$message = 	"There are no completed tasks at the moment.";
		} else {
		$message = 	"There are no pending tasks at the moment.";
		}
		 ?>
		<?php echo $message; ?>

	</div>
<?php } ?>

		</div>
		
	</div>

	<div class="panel-footer">
		<span class="label label-danger"><i class="fa fa-clock-o"></i> Pending</span>
		<span class="label label-success"><i class="fa fa-check-circle"></i> Complete</span> 
	</div>

</div>
