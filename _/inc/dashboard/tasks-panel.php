<?php
$today = date('Ymd'); 
$weeks_before = date('Ymd', strtotime('today - 4 weeks'));
$weeks_after = date('Ymd', strtotime('today + 4 weeks'));
if ( get_query_var('paged') ) {

    $paged = get_query_var('paged');

} elseif ( get_query_var('page') ) {

    $paged = get_query_var('page');

} else {

    $paged = 1;

}
$posts_per_page = 5;

$task_args = array(
'post_type'	=> 'tlw_task',
/* 'posts_per_page' => -1, */
'posts_per_page' => $posts_per_page,
'paged'		=> $paged,
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

$wp_query = new WP_Query($task_args);
//echo '<pre>';print_r($wp_query);echo '</pre>';
$found_posts =  $wp_query->found_posts;
$max_num_pages = $wp_query->max_num_pages;

//echo '<pre>';print_r($task_args);echo '</pre>';
?>
<a id="tasks-panel" name="tasks-panel"></a>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Current Tasks</h3>
	</div>
	
		
	<div id="tasks-wrap" class="content-wrap">
		<div class="content-inner">
		
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-6">
				<div class="btn-group filter-actions">
					<a href="?tasks-filter=pending#tasks-panel" class="btn btn-danger<?php echo ($_GET['tasks-filter'] == 'pending' || !isset($_GET['tasks-filter']))? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending</a>
					<a href="?tasks-filter=complete#tasks-panel" class="btn btn-success<?php echo ($_GET['tasks-filter'] == 'complete')? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete</a>
				</div>
			</div>
			<div class="col-xs-6 text-right">
				<div class="btn-group">
		 			<a href="?request=add-task" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Task</span></a>
				</div>
			</div>
		</div>
	</div>
		
	<?php if (have_posts()) : ?>
		
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
				
				<?php while ( have_posts() ) :the_post(); 	
				$project_id = get_field('project');
				$priority_level = get_field('priority_level');
				if (empty($priority_level)) {
				$priority_level = "4";
				update_post_meta(get_the_ID(), 'priority_level', $priority_level);	
				$priority_level = get_field('priority_level');
				}
				$project_title = get_the_title($project_id);
				$project = get_post($project_id);
				$task_date = get_field('task_date');
				$status = get_field('task_status');
				$company = wp_get_post_terms($project_id, 'tlw_company_tax', array("fields" => "names"));
				$media_type = get_the_term_list($project_id, 'tlw_media_types', '', ', ');
				$project_author = get_the_author_meta( "display_name", $project->post_author );
				//echo '<pre>';print_r($media_type);echo '</pre>';
				$download = get_field('gdrive_link');
				?>
				<tr class="<?php echo ($status == 'pending') ? 'danger':'success'; ?>">
					<td>
						<span class="create-date label label-<?php echo ($status == 'pending') ? 'danger':'success'; ?>">
							<span class="mth"><?php echo date("M", strtotime($task_date)); ?></span>
							<span class="dy"><?php echo date("j", strtotime($task_date)); ?></span>
							<span class="yr"><?php echo date("Y", strtotime($task_date)); ?></span>
						</span>
					</td>
					<td>
					<p class="bold"><i class="fa <?php echo ($status == 'pending') ? 'fa-clock-o col-danger':'fa-check-circle col-success'; ?>"></i> <?php the_title(); ?></p>
						<span class="label label-default"> <i class="fa fa-user"></i> <?php the_author(); ?></span>
						<span class="label label-default"> <i class="fa fa-building-o"></i> <?php echo $company[0]; ?></span>
						<?php if ($status == 'pending' && $priority_level) { 
							switch($priority_level) {
							case "1": $priority_level_txt = "Urgent"; $priority_level_class = "danger";
							break;
							case "2": $priority_level_txt = "High"; $priority_level_class = "warning";
							break;
							case "3": $priority_level_txt = "Medium"; $priority_level_class = "primary";
							break;
							default: $priority_level_txt = "Low"; $priority_level_class = "info";	
							}
						?>
						
						<span class="label label-<?php echo $priority_level_class; ?>"> <i class="fa fa-sort"></i> <?php echo $priority_level_txt; ?></span>
						
						<?php } ?>
					</td>
					<td class="hidden-xs text-center">
						<span class="label label-default"> <i class="fa fa-user"></i> <?php echo $project_author; ?></span>
						<span class="label label-default"> <i class="fa fa-cog"></i> <?php echo $project_title; ?></span>
					</td>
					
					<td>
						<div class="btn-group pull-right">
						<button type="button" class="btn btn-<?php echo ($status == 'pending') ? 'danger':'success'; ?> dropdown-toggle" data-toggle="dropdown">
						 <i class="fa fa-cogs fa-lg"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo get_permalink($project_id); ?><?php echo ($status == 'completed') ? '?tasks-filter=complete':''; ?>"><i class="fa fa-eye"></i> View Project</a></li>
							<?php if ($status == 'pending') { ?>
							<li><a href="?request=completed&tid=<?php echo get_the_ID(); ?>&pid=<?php echo $project_id; ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-check"></i> Complete task</a></li>
							<?php } ?>
							<li><a href="?request=edit-task&tid=<?php echo get_the_ID(); ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-pencil"></i> Edit task</a></li>
							<li><a href="?request=delete-task&tid=<?php echo get_the_ID(); ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-trash"></i> Delete task</a></li>
							<?php if ($download) { ?>
							<li><a href="<?php echo $download; ?>" target="_blank"><i class="fa fa-link"></i> View Link</a></li>
							<?php } else { ?>
							<li><a href="?request=add-link&tid=<?php echo get_the_ID(); ?><?php echo ($status == 'completed') ? '&tasks-filter=complete':''; ?>#tasks-panel" class="request-btn"><i class="fa fa-link"></i> Add Link</a></li>
							<?php } ?>
						</ul>
					</div>

					</td>
				</tr>
				<?php endwhile; ?>
				
				</tbody>
			</table>
			</div>
			
		<div class="panel-footer">
			<div class="row">
				<div class="col-xs-3">
					<span class="label label-primary"><i class="fa fa-file"></i> Page <?php echo $paged; ?> of <?php echo $max_num_pages; ?></span>
				</div>
	
				<div class="col-xs-9">
					<?php 
						if (isset($_GET['tasks-filter'])) {
						$format = '&paged=%#%';	
						} else {
						$format = '?paged=%#%';		
						}
						$pagination =  paginate_links(array(  
					                  'base' => get_pagenum_link(1) . '%_%',  
					                  'format' => $format,  
					                  'current' => $paged,  
					                  'total' => $max_num_pages,  
					                  'type'	=> 'array',
					                  'prev_text' => '&laquo; Previous',  
					                  'next_text' => 'Next &raquo;'  
					                )); 
					   //echo '<pre>';print_r($pagination);echo '</pre>';        
					                
					     ?>
				     
						 <?php if ($found_posts > $posts_per_page) { ?>
					     <ul class="pagination pull-right">
					     	<?php foreach ($pagination as $pag) { 
					     	$cur_pg = strip_tags($pag);
						 	?>
					     	<li<?php echo ($paged == $cur_pg) ? ' class="active"':'' ; ?>><?php echo $pag; ?></li>
					     	<?php } ?>
					     </ul>
					     <?php } ?>

				</div>
			</div>
		</div>

		<?php else: ?>
		
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
		
		<?php endif; ?>
		
		<?php wp_reset_query(); ?>
		
		</div>
		
	</div>
	
</div>
