<?php
$today = date('Ymd'); 
$weeks_before = date('Ymd', strtotime('today - 2 weeks'));
$weeks_after = date('Ymd', strtotime('today + 2 weeks'));

$task_args = array(
'post_type'	=> 'tlw_task',
'posts_per_page' => -1,
'orderby'	=>	'meta_value_num',
'order'		=> 'DESC',
'meta_query'	=> array(
'relation'	=> 'AND',
	array(
	'key'	=> 'task_date',
	'value' => $weeks_before,
	'compare' =>	'>=' 
	),
	array(
	'key'	=> 'task_date',
	'value' => $weeks_after,
	'compare' =>	'<=' 
	)
	)
);

if (isset($_GET['tasks-filter'])) {

	if ($_GET['tasks-filter'] == 'pending') {
		array_push($task_args['meta_query'], array('key' => 'task_status','value' => "pending") );
	} 
	
	if ($_GET['tasks-filter'] == 'complete') {
		array_push($task_args['meta_query'], array('key' => 'task_status','value' => "completed") );
	}
	
} else {
	array_push($task_args['meta_query'], array('key' => 'task_status','value' => "pending") );
}

$tasks = get_posts($task_args);

//echo '<pre>';print_r($task_args);echo '</pre>';
?>
<a id="tasks-panel" name="tasks-panel"></a>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Recent Tasks</h3>
	</div>
	
		
	<div id="tasks-wrap" class="content-wrap">
		<div class="content-inner">
		
	<div class="panel-body text-center">
		<div class="btn-group filter-actions">
			<a href="?tasks-filter=pending#tasks-panel" class="btn btn-danger<?php echo ($_GET['tasks-filter'] == 'pending' || !isset($_GET['tasks-filter']))? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending</a>
			<a href="?tasks-filter=complete#tasks-panel" class="btn btn-success<?php echo ($_GET['tasks-filter'] == 'complete')? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete</a>
		</div>
	</div>
		
	<?php if ($tasks) { ?>
		
		<div class="table-responsive">
			<table class="table table-bordered">
			
				<thead>
					<tr>
						<th width="50">Date</th>
						<th>Task</th>
						<th class="hidden-xs text-center">Project</th>
						<th class="text-right" width="5%">Actions</th>
					</tr>
				</thead>
				<tbody>
				
				<?php foreach ($tasks as $t) { 
				$title = get_the_title($t->ID);	
				$project_id = get_field('project', $t->ID);
				$project_title = get_the_title($project_id);
				$created_by = get_userdata($t->post_author);
				$task_date = get_field('task_date', $t->ID);
				$status = get_field('task_status', $t->ID);
				$company = wp_get_post_terms($project_id, 'tlw_company_tax', array("fields" => "names"));
				$media_type = get_the_term_list($project_id, 'tlw_media_types', '', ', ');
				//echo '<pre>';print_r($media_type);echo '</pre>';
				$download = get_field('gdrive_link', $t->ID);
				?>
				<tr class="<?php echo ($status == 'pending') ? 'danger':'success'; ?>">
					<td>
						<span class="create-date label label-<?php echo ($status == 'pending') ? 'danger':'success'; ?>">
							<span class="mth"><?php echo date("M", strtotime($date)); ?></span>
							<span class="dy"><?php echo date("j", strtotime($date)); ?></span>
							<span class="yr"><?php echo date("Y", strtotime($date)); ?></span>
						</span>
					</td>
					<td>
					<p class="bold"><i class="fa <?php echo ($status == 'pending') ? 'fa-clock-o col-danger':'fa-check-circle col-success'; ?>"></i> <?php echo $title; ?></p>
						<span class="label label-default"> <i class="fa fa-user"></i> <?php echo $created_by->data->display_name; ?></span>
						<span class="label label-default"> <i class="fa fa-building-o"></i> <?php echo $company[0]; ?></span>
					</td>
					<td class="hidden-xs text-center"><span class="label label-default"> <i class="fa fa-cog"></i> <?php echo $project_title; ?></span></td>
					
					<td>
						<div class="btn-group pull-right">
						<button type="button" class="btn btn-<?php echo ($status == 'pending') ? 'danger':'success'; ?> dropdown-toggle" data-toggle="dropdown">
						 <i class="fa fa-cogs fa-lg"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo get_permalink($project_id); ?><?php echo ($status == 'completed') ? '?tasks-filter=complete':''; ?>"><i class="fa fa-eye"></i> View Project</a></li>
							<?php if ($status == 'pending') { ?>
							<li><a href="?request=completed&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-check"></i> Complete task</a></li>
							<?php } ?>
							<li><a href="?request=edit-task&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-pencil"></i> Edit task</a></li>
							<li><a href="?request=delete-task&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-trash"></i> Delete task</a></li>
							<?php if ($download) { ?>
							<li><a href="<?php echo $download; ?>" target="_blank"><i class="fa fa-link"></i> View Link</a></li>
							<?php } else { ?>
							<li><a href="?request=add-link&tid=<?php echo $t->ID; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-link"></i> Add Link</a></li>
							<?php } ?>
						</ul>
					</div>

					</td>
				</tr>
				<?php } ?>
				
				</tbody>
			</table>
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
		<div class="row">
			<div class="col-xs-9">
				<span class="label label-danger"><i class="fa fa-clock-o"></i> Pending</span>
		 		<span class="label label-success"><i class="fa fa-check-circle"></i> Completed</span>
			</div>

			<div class="col-xs-3">
				<div class="btn-group">
		 			<a href="?request=add-task" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Task</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
