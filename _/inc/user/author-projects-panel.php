<?php 
//echo '<pre>';print_r($wp_query);echo '</pre>';;
$projects_pg = get_page_by_title("Projects");
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 5;
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );	
global $current_user;
//echo '<pre>';print_r($author);echo '</pre>';

$project_args = array(
'post_type'	=> 'tlw_project',
'posts_per_page' => $posts_per_page,
'meta_key'	=> 'project_start_date',
'orderby'	=>	'meta_value_num',
'order'		=> 'DESC',
'paged'		=> $paged,
'author'	=> $author->ID
);

if (isset($_GET['projects-filter'])) {

	if ($_GET['projects-filter'] == 'pending') {
		$project_args['meta_query']	= array( array('key' => 'project_completed_date','value' => "",'compare' => "=") );
	
	} 
	
	if ($_GET['projects-filter'] == 'complete') {
		$project_args['meta_query']	= array( array('key' => 'project_completed_date','value' => "",'compare' => "!=") );
	}
	
} else {
	$project_args['meta_query']	= array( array('key' => 'project_completed_date','value' => "",'compare' => "=") );
}

$wp_query = new WP_Query($project_args);
$found_posts =  $wp_query->found_posts;
$max_num_pages = $wp_query->max_num_pages;
//echo '<pre>';print_r($paged);echo '</pre>';
 ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><?php echo ($author->ID == $current_user->ID)? 'Your ':''; ?>Projects<?php echo ($author->ID != $current_user->ID)? ' by '.$author->data->display_name:'' ?></h3>
	</div>
	
	<div id="projects-wrap" class="content-wrap">
		<div class="content-inner">
	
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-6">
		<div class="btn-group filter-actions">
			<a href="?projects-filter=pending" class="btn btn-danger<?php echo ($_GET['projects-filter'] == 'pending' || !isset($_GET['projects-filter']))? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending</a>
			<a href="?projects-filter=complete" class="btn btn-success<?php echo ($_GET['projects-filter'] == 'complete')? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete</a>
		</div>
		</div>
			<div class="col-xs-6 text-right">
				<div class="btn-group">
					<?php if ($current_user->ID == $user_id) { ?>
					<a href="?request=add-project" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Project</span></a>
					<?php } ?>
					<a href="<?php echo get_permalink($projects_pg->ID); ?>" class="btn btn-primary" role="button"><i class="fa fa-eye"></i>  <span class="txt">All Projects</span></a>
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
						<th class="text-center">Project</th>
						<th class="visible-lg text-center" width="20%">Media type</th>
						<th class="hidden-xs text-center" width="5%">Tasks</th>
						<th class="text-right" width="5%">Actions</th>
					</tr>
				</thead>
				<tbody>
				
				<?php while ( have_posts() ) :the_post();
				$date = get_field('project_start_date');	
				$created_by = get_userdata($post->post_author);	
				$end_date = get_field('project_completed_date');	
				$company = wp_get_post_terms(get_the_ID(), 'tlw_company_tax', array("fields" => "names"));
				$media_type = get_the_term_list(get_the_ID(), 'tlw_media_types', '', ', ');
				$tasks_args = array(
				'post_type'	=> 'tlw_task',
				'posts_per_page' => -1
				);
				if ($end_date) {
				$tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'completed'));
				} else {
				$tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'pending'));	
				}
				$tasks = get_posts($tasks_args);

				$task_count = ($tasks) ? count($tasks) : 0;
				//echo '<pre>';print_r($media_type);echo '</pre>';
				?>
				<tr class="<?php echo ($end_date) ? 'success':'danger'; ?>">
					<td>
						<span class="create-date label label-<?php echo ($end_date) ? 'success':'danger'; ?>">
							<span class="mth"><?php echo date("M", strtotime($date)); ?></span>
							<span class="dy"><?php echo date("j", strtotime($date)); ?></span>
							<span class="yr"><?php echo date("Y", strtotime($date)); ?></span>
						</span>
					</td>
					<td>
						<p class="bold">
						<i class="fa <?php echo ($end_date) ? 'fa-check-circle col-success':'fa-clock-o col-danger'; ?>"></i> 
						<?php the_title(); ?></p>

						<span class="label label-default"> <i class="fa fa-building-o"></i> <?php echo $company[0]; ?></span>
					</td>
					<td class="visible-lg text-center"><span class="label label-default"><?php echo strip_tags($media_type); ?></span></td>
					<td class="hidden-xs text-center"><span class="badge"><?php echo $task_count; ?></span></td>
					<td>
						<a href="<?php the_permalink(); ?>" class="visible-xs btn btn-<?php echo ($end_date) ? 'success':'danger'; ?>"><i class="fa fa-angle-right"></i></a>
						<div class="hidden-xs btn-group pull-right">
						<button type="button" class="btn btn-<?php echo ($end_date) ? 'success':'danger'; ?> dropdown-toggle" data-toggle="dropdown">
						 <i class="fa fa-cogs fa-lg"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i> View Project</a></li>
							<?php if (empty($end_date)) { ?>
							<li><a href="?request=complete-project&pid=<?php echo get_the_ID(); ?>" class="request-btn"><i class="fa fa-check"></i> Complete Project</a></li>
							<?php }  ?>
							<li><a href="?request=edit-project&pid=<?php echo get_the_ID(); ?><?php echo ($end_date) ? '&projects-filter=complete':''; ?>" class="request-btn"><i class="fa fa-pencil"></i> Edit Project</a></li>
							<li><a href="?request=delete-project&pid=<?php echo get_the_ID(); ?><?php echo ($end_date) ? '&projects-filter=complete':''; ?>" class="request-btn"><i class="fa fa-trash"></i> Delete Project</a></li>
							<li><a href="?request=add-task&pid=<?php echo get_the_ID(); ?><?php echo ($end_date) ? '&projects-filter=complete':''; ?>" class="request-btn"><i class="fa fa-plus"></i> Add Task</a></li>
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
				
					<div class="col-xs-6">
					<span class="label label-primary"><i class="fa fa-file"></i> Page <?php echo $paged; ?> of <?php echo $max_num_pages; ?></span> 
					</div>
					
					<div class="col-xs-6">
					<?php 
						if (isset($_GET['projects-filter'])) {
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
		<span class="fa fa-cogs fa-4x block icon"></span>
		<?php 
		if ( $_GET['projects-filter'] == 'complete' ) {
			if ($author->ID == $current_user->ID) {
			$message = 	"You have no completed projects at the moment.";
			} else {
			$message = 	$author->data->display_name." has no completed projects at the moment.";	
			}
		} else {
			if ($author->ID == $current_user->ID) {
			$message = 	"You have no pending projects at the moment.";	
			} else {
			$message = 	$author->data->display_name." has no pending projects at the moment.";	
			}
		}
		 ?>
		<?php echo $message; ?>
		</div>
		<?php endif;
		wp_reset_query();
		 ?>
		 
		 	</div>
		
		</div>
</div>
