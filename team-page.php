<?php
/*
Template Name: Team list page
*/
?>

<?php get_header(); ?>

<?php 
$number 	= 6;
$paged 		= (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset 	= ($paged - 1) * $number;
$users 		= get_users($users_args);
$query_args = array(
'offset'	=> $offset,
'number'	=> $number,
'meta_key'	=> 'last_name',
'orderby'	=> 'meta_value'
);
$query = new WP_User_Query($query_args);
$total_users = count($users);
$total_query = count($query);
$total_pages = intval($total_users / $number) + 1;
$user_counter = 0;
//echo '<pre>';print_r($query);echo '</pre>';
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><?php the_title(); ?> members</h3>
	</div>
	
	<div id="team-wrap" class="content-wrap">
		<div class="content-inner">
		<?php if ($total_users > 0) { ?>
		
		<div class="panel-body users-list">
				
				<div class="row">
				
				<?php foreach ($query->results as $user) { 
				
				$project_args = array(
				'post_type'	=> 'tlw_project',
				'posts_per_page' => -1,
				'author'	=> $user->ID
				);
				
				$project_args['meta_query']	= array( array('key' => 'project_completed_date','value' => "",'compare' => "=") );
				
				$pending_projects = get_posts($project_args);
				
				$project_args['meta_query']	= array( array('key' => 'project_completed_date','value' => "",'compare' => "!=") );
				
				$completed_projects = get_posts($project_args);
				
				$task_args = array(
				'post_type'	=> 'tlw_task',
				'posts_per_page' => -1,
				'author'	=> $user->ID
				);
				
				$task_args['meta_query'] = array( array('key' => 'task_status','value' => "pending") );
				
				$pending_tasks = get_posts($task_args);
				
				$task_args['meta_query'] = array( array('key' => 'task_status','value' => "completed") );
				
				$completed_tasks = get_posts($task_args);

				?>
				
				<div class="col-sm-6 col-md-4">
				
					<div class="user-info-wrap">
					
				        <div class="user-avatar"><?php echo get_avatar( $user->ID, 150 ); ?></div>  
				        <a href="<?php echo get_author_posts_url($user->ID);?>" title="View Profile" class="btn btn-primary btn-block user-link float-icon">
				        <i class="fa fa-user fa-lg"></i> <span class="user-name"> <?php echo get_the_author_meta('first_name', $user->ID);?> <?php echo get_the_author_meta('last_name', $user->ID);?></span></a>   
				         <ul class="list-group">
				         	<li class="list-group-item">Pending Projects <span class="badge pull-right"><?php echo count($pending_projects); ?></span></li>
				         	<li class="list-group-item">Completed Projects <span class="badge pull-right"><?php echo count($completed_projects); ?></span></li>
				         	<li class="list-group-item">Pending Tasks <span class="badge pull-right"><?php echo count($pending_tasks); ?></span></li>
				         	<li class="list-group-item">Completed Tasks <span class="badge pull-right"><?php echo count($completed_tasks); ?></span></li>
				         </ul>
				        
				    </div>
			    
				</div>
			    
				<?php } ?>
				
				</div>
				
		</div>
				
		<div class="panel-footer">
				
			<div class="row">
				
					<div class="col-xs-6">
						<span class="label label-primary"><i class="fa fa-file"></i> Page <?php echo $paged; ?> of <?php echo $total_pages; ?></span> 
					</div>
					<div class="col-xs-6">
					<?php 
					 $pagination =  paginate_links(array(  
				                  'base' => get_pagenum_link(1) . '%_%',  
				                  'format' => '?paged=%#%', 
				                  'current' => $paged,  
				                  'total' => $total_pages,  
				                  'type'	=> 'array',
				                  'prev_text' => '&laquo; Previous',  
				                  'next_text' => 'Next &raquo;'  
				                )); 
					 ?>	
					
					<?php if ($total_users > $number) { ?>
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
	
		</div>
		
		<?php } else { ?>
		<div class="panel-body text-center">
			<span class="fa fa-cogs fa-4x block icon"></span>
			No team members at the moment.
		</div>
		<?php } ?>
		
		</div>
	</div>

</div>


<?php get_footer(); ?>